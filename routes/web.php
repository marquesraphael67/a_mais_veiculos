<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminVeiculoController;
use App\Http\Controllers\Admin\AdminMarcaController;
use Illuminate\Support\Facades\Route;

// ========== ROTAS DO SITE PÚBLICO ==========
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/veiculo/{id}', [SiteController::class, 'show'])->name('veiculo.show');
Route::post('/filtrar', [SiteController::class, 'filtrar'])->name('filtrar');

// ========== ROTAS DO ADMIN ==========
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rotas de login (acesso público)
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/auth', [AdminController::class, 'auth'])->name('auth');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // Rotas protegidas (requer autenticação)
    Route::middleware('auth')->group(function () {
        
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Rotas de Veículos
        Route::get('/veiculos', [AdminVeiculoController::class, 'index'])->name('veiculos.index');
        Route::get('/veiculos/observacoes', [AdminVeiculoController::class, 'observacoes'])->name('veiculos.observacoes');
        Route::get('/veiculos/create', [AdminVeiculoController::class, 'create'])->name('veiculos.create');
        Route::post('/veiculos', [AdminVeiculoController::class, 'store'])->name('veiculos.store');
        Route::get('/veiculos/{id}/edit', [AdminVeiculoController::class, 'edit'])->name('veiculos.edit');
        Route::put('/veiculos/{id}', [AdminVeiculoController::class, 'update'])->name('veiculos.update');
        Route::delete('/veiculos/{id}', [AdminVeiculoController::class, 'destroy'])->name('veiculos.destroy');
        Route::delete('/veiculos/foto/{id}', [AdminVeiculoController::class, 'deleteFoto'])->name('veiculos.delete-foto');
        
        // Rotas de Marcas
        Route::get('/marcas', [AdminMarcaController::class, 'index'])->name('marcas.index');
        Route::get('/marcas/create', [AdminMarcaController::class, 'create'])->name('marcas.create');
        Route::post('/marcas', [AdminMarcaController::class, 'store'])->name('marcas.store');
        Route::get('/marcas/{id}/edit', [AdminMarcaController::class, 'edit'])->name('marcas.edit');
        Route::put('/marcas/{id}', [AdminMarcaController::class, 'update'])->name('marcas.update');
        Route::delete('/marcas/{id}', [AdminMarcaController::class, 'destroy'])->name('marcas.destroy');
    });
});