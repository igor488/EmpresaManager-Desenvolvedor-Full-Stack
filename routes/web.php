<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Grupos;
use App\Livewire\Bandeiras;
use App\Livewire\Unidades;
use App\Livewire\Colaboradores;
use App\Livewire\VisualizarAuditorias;
use App\Livewire\RelatorioColaboradores;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Dashboard com controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rotas protegidas
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔹 ROTAS DO FRONTEND (Livewire)
    Route::get('/livewire/grupos', Grupos::class)->name('livewire.grupos');
    Route::get('/livewire/bandeiras', Bandeiras::class)->name('livewire.bandeiras');
    Route::get('/livewire/unidades', Unidades::class)->name('livewire.unidades');
    Route::get('/livewire/colaboradores', Colaboradores::class)->name('livewire.colaboradores');
    Route::get('/auditorias', VisualizarAuditorias::class)->name('auditorias');
    Route::get('/relatorio-colaboradores', RelatorioColaboradores::class)->name('relatorio.colaboradores');


});

require __DIR__ . '/auth.php';
