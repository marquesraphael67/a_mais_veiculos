<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminVeiculoController;
use App\Http\Controllers\AdminMarcaController;
use Illuminate\Support\Facades\Route;

// Rotas do site público
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/veiculo/{id}', [SiteController::class, 'show']);
Route::post('/filtrar', [SiteController::class, 'filtrar']);

// Rotas do admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/auth', [AdminController::class, 'auth']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/veiculos', [AdminVeiculoController::class, 'index'])->name('admin.veiculos.index');
        Route::get('/veiculos/create', [AdminVeiculoController::class, 'create'])->name('admin.veiculos.create');
        Route::post('/veiculos', [AdminVeiculoController::class, 'store'])->name('admin.veiculos.store');
        Route::get('/veiculos/{id}/edit', [AdminVeiculoController::class, 'edit'])->name('admin.veiculos.edit');
        Route::put('/veiculos/{id}', [AdminVeiculoController::class, 'update'])->name('admin.veiculos.update');
        Route::delete('/veiculos/{id}', [AdminVeiculoController::class, 'destroy'])->name('admin.veiculos.destroy');
        Route::delete('/veiculos/foto/{id}', [AdminVeiculoController::class, 'deleteFoto'])->name('admin.veiculos.delete-foto');
        
        Route::get('/marcas', [AdminMarcaController::class, 'index'])->name('admin.marcas.index');
        Route::get('/marcas/create', [AdminMarcaController::class, 'create'])->name('admin.marcas.create');
        Route::post('/marcas', [AdminMarcaController::class, 'store'])->name('admin.marcas.store');
        Route::get('/marcas/{id}/edit', [AdminMarcaController::class, 'edit'])->name('admin.marcas.edit');
        Route::put('/marcas/{id}', [AdminMarcaController::class, 'update'])->name('admin.marcas.update');
        Route::delete('/marcas/{id}', [AdminMarcaController::class, 'destroy'])->name('admin.marcas.destroy');
    });
    Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/auth', [AdminController::class, 'auth']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    // Rotas protegidas - USAR middleware web
    Route::middleware(['web', 'auth'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/veiculos', [AdminVeiculoController::class, 'index'])->name('admin.veiculos.index');
        Route::get('/veiculos/create', [AdminVeiculoController::class, 'create'])->name('admin.veiculos.create');
        Route::post('/veiculos', [AdminVeiculoController::class, 'store'])->name('admin.veiculos.store');
        Route::get('/veiculos/{id}/edit', [AdminVeiculoController::class, 'edit'])->name('admin.veiculos.edit');
        Route::put('/veiculos/{id}', [AdminVeiculoController::class, 'update'])->name('admin.veiculos.update');
        Route::delete('/veiculos/{id}', [AdminVeiculoController::class, 'destroy'])->name('admin.veiculos.destroy');
        Route::delete('/veiculos/foto/{id}', [AdminVeiculoController::class, 'deleteFoto'])->name('admin.veiculos.delete-foto');
        
        Route::get('/marcas', [AdminMarcaController::class, 'index'])->name('admin.marcas.index');
        Route::get('/marcas/create', [AdminMarcaController::class, 'create'])->name('admin.marcas.create');
        Route::post('/marcas', [AdminMarcaController::class, 'store'])->name('admin.marcas.store');
        Route::get('/marcas/{id}/edit', [AdminMarcaController::class, 'edit'])->name('admin.marcas.edit');
        Route::put('/marcas/{id}', [AdminMarcaController::class, 'update'])->name('admin.marcas.update');
        Route::delete('/marcas/{id}', [AdminMarcaController::class, 'destroy'])->name('admin.marcas.destroy');
    });
});
});