<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Loja\LojaController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════════════
//  LOJA PÚBLICA — tenant identificado automaticamente pelo host/porta
//  localhost:8000 → Empresa A | localhost:8001 → Empresa B
//  Em produção: loja-a.com → Empresa A | loja-b.com → Empresa B
// ══════════════════════════════════════════════════════════════════
Route::middleware('tenant.loja')->group(function () {
    Route::get('/', [LojaController::class, 'index'])->name('loja.home');
    Route::get('/produto/{id}', [LojaController::class, 'show'])->name('loja.produto');
});

// ══════════════════════════════════════════════════════════════════
//  PAINEL ADMIN — apenas o dono da loja (logado)
// ══════════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {

    // Login / Logout (públicos dentro do /admin)
    Route::get('/login',   [LoginController::class, 'index'])->name('login');
    Route::post('/logar',  [LoginController::class, 'logar'])->name('logar');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rotas protegidas por autenticação de empresa
    Route::middleware('empresa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('produtos', ProdutoController::class);
        Route::resource('banners',  BannerController::class);
    });
});
