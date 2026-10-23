<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaidaResource;
use App\Models\Saida;
use Illuminate\Http\Request;
class SaidaController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['data' => ['nullable', 'date'], 'passeio' => ['nullable', 'string']]);
        $query = Saida::with(['passeio', 'reservas'])->whereDate('data', $request->query('data', now()->toDateString()));
        if ($request->filled('passeio')) $query->whereHas('passeio', fn($q) => $q->where('slug', $request->passeio));
        return SaidaResource::collection($query->orderBy('horario')->get());
    }
}
