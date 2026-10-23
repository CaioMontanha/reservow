<?php
namespace App\Http\Controllers\Api;
use App\Enums\StatusReserva;
use App\Exceptions\SemVagasException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Resources\ReservaResource;
use App\Models\Reserva;
use App\Models\Saida;
use App\Services\ReservaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['data' => ['nullable', 'date'], 'status' => ['nullable', 'in:pendente,confirmada,cancelada'], 'passeio' => ['nullable', 'string']]);
        $query = Reserva::with('saida.passeio')->orderByDesc('created_at');
        if ($request->filled('data')) $query->whereHas('saida', fn($q) => $q->whereDate('data', $request->data));
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('passeio')) $query->whereHas('saida.passeio', fn($q) => $q->where('slug', $request->passeio));
        return ReservaResource::collection($query->paginate(15));
    }
    public function store(StoreReservaRequest $request)
    {
        $saida = Saida::with('passeio')->findOrFail($request->integer('saida_id'));
        if ($saida->data->isPast() && !$saida->data->isToday()) return response()->json(['erro' => 'saida_passada', 'mensagem' => 'Não é possível reservar uma saída passada.'], 422);
        if (!$saida->passeio->ativo) return response()->json(['erro' => 'passeio_inativo', 'mensagem' => 'Este passeio está inativo.'], 422);
        $reserva = Reserva::create([...$request->validated(), 'codigo' => Str::upper(Str::random(8)), 'status' => StatusReserva::Pendente]);
        return (new ReservaResource($reserva->load('saida.passeio')))->response()->setStatusCode(201);
    }
    public function show(Reserva $reserva) { return new ReservaResource($reserva->load('saida.passeio')); }
    public function confirmar(Reserva $reserva, ReservaService $service) { return $this->transicionar($reserva, StatusReserva::Confirmada, $service); }
    public function cancelar(Reserva $reserva, ReservaService $service) { return $this->transicionar($reserva, StatusReserva::Cancelada, $service); }
    private function transicionar(Reserva $reserva, StatusReserva $destino, ReservaService $service)
    {
        try { return new ReservaResource($service->transicionar($reserva, $destino)); }
        catch (SemVagasException $e) { return response()->json(['erro' => 'sem_vagas', 'mensagem' => $e->getMessage(), 'vagas_restantes' => $e->vagasRestantes], 409); }
        catch (ValidationException $e) { return response()->json(['erro' => 'transicao_invalida', 'mensagem' => collect($e->errors())->flatten()->first()], 422); }
    }
}
