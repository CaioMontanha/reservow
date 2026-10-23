<?php
namespace App\Http\Controllers;
use App\Models\Passeio;
use App\Models\Reserva;
use App\Models\Saida;
use Illuminate\Http\Request;
class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $query = Reserva::with('saida.passeio')->orderByDesc('id');
        if ($request->filled('data')) $query->whereHas('saida', fn($q) => $q->whereDate('data', $request->data));
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('passeio')) $query->whereHas('saida.passeio', fn($q) => $q->where('slug', $request->passeio));
        $reservas = $query->paginate(15)->withQueryString();
        $passeios = Passeio::where('ativo', true)->orderBy('nome')->get();
        return view('reservas.index', compact('reservas', 'passeios'));
    }
    public function create(Request $request)
    {
        $request->validate(['data' => ['nullable', 'date_format:Y-m-d']]);
        $data = $request->query('data', now()->toDateString());
        $saidas = Saida::with(['passeio', 'reservas'])->whereDate('data', $data)->whereHas('passeio', fn($q) => $q->where('ativo', true))->orderBy('horario')->get();
        return view('reservas.create', compact('data', 'saidas'));
    }
}
