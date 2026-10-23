<?php
namespace App\Http\Controllers;
use App\Models\Saida;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['data' => ['nullable', 'date_format:Y-m-d']]);
        $data = $request->query('data', now()->toDateString());
        $saidas = Saida::with(['passeio', 'reservas'])->whereDate('data', $data)->orderBy('horario')->get();
        return view('dashboard', compact('data', 'saidas'));
    }
}
