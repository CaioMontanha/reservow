<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Passeio;
use Illuminate\Http\JsonResponse;
class PasseioController extends Controller
{
    public function index(): JsonResponse { return response()->json(Passeio::where('ativo', true)->orderBy('nome')->get(['id', 'nome', 'slug', 'capacidade_padrao'])); }
}
