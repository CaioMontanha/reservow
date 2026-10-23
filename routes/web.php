<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
Route::get('/reservas/nova', [ReservaController::class, 'create'])->name('reservas.create');
