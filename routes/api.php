<?php
use App\Http\Controllers\Api\PasseioController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\SaidaController;
use Illuminate\Support\Facades\Route;
Route::get('/passeios', [PasseioController::class, 'index']);
Route::get('/saidas', [SaidaController::class, 'index']);
Route::get('/reservas', [ReservaController::class, 'index']);
Route::post('/reservas', [ReservaController::class, 'store']);
Route::get('/reservas/{reserva}', [ReservaController::class, 'show']);
Route::patch('/reservas/{reserva}/confirmar', [ReservaController::class, 'confirmar']);
Route::patch('/reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar']);
