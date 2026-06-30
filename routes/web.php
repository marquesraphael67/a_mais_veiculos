<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMarcaController;
use App\Http\Controllers\Admin\AdminVeiculoController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Login padrão redireciona para login do admin
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// SITE PÚBLICO
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/veiculo/{id}', [SiteController::class, 'show'])
    ->whereNumber('id')
    ->name('veiculo.show');

Route::post('/filtrar', [SiteController::class, 'filtrar'])->name('filtrar');

// ADMIN
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminController::class, 'login'])->name('login');
        Route::post('/auth', [AdminController::class, 'auth'])->name('auth');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/veiculos', [AdminVeiculoController::class, 'index'])->name('veiculos.index');
        Route::get('/veiculos/observacoes', [AdminVeiculoController::class, 'observacoes'])->name('veiculos.observacoes');
        Route::get('/veiculos/create', [AdminVeiculoController::class, 'create'])->name('veiculos.create');
        Route::post('/veiculos', [AdminVeiculoController::class, 'store'])->name('veiculos.store');
        Route::get('/veiculos/{id}/edit', [AdminVeiculoController::class, 'edit'])
            ->whereNumber('id')
            ->name('veiculos.edit');
        Route::put('/veiculos/{id}', [AdminVeiculoController::class, 'update'])
            ->whereNumber('id')
            ->name('veiculos.update');
        Route::delete('/veiculos/{id}', [AdminVeiculoController::class, 'destroy'])
            ->whereNumber('id')
            ->name('veiculos.destroy');

        Route::patch('/veiculos/{id}/toggle-ativo', [AdminVeiculoController::class, 'toggleAtivo'])
            ->whereNumber('id')
            ->name('veiculos.toggle-ativo');

        Route::delete('/veiculos/foto/{id}', [AdminVeiculoController::class, 'deleteFoto'])
            ->whereNumber('id')
            ->name('veiculos.delete-foto');

        Route::get('/marcas', [AdminMarcaController::class, 'index'])->name('marcas.index');
        Route::get('/marcas/create', [AdminMarcaController::class, 'create'])->name('marcas.create');
        Route::post('/marcas', [AdminMarcaController::class, 'store'])->name('marcas.store');
        Route::get('/marcas/{id}/edit', [AdminMarcaController::class, 'edit'])
            ->whereNumber('id')
            ->name('marcas.edit');
        Route::put('/marcas/{id}', [AdminMarcaController::class, 'update'])
            ->whereNumber('id')
            ->name('marcas.update');
        Route::delete('/marcas/{id}', [AdminMarcaController::class, 'destroy'])
            ->whereNumber('id')
            ->name('marcas.destroy');
    });
});