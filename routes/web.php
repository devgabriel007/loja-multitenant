<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Loja\LojaController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════════════
//  LOJA PÚBLICA — tenant identificado automaticamente
//  Desenvolvimento: localhost:8000 → Empresa A | localhost:8001 → Empresa B
//  Produção:        loja-a.com → Empresa A | loja-b.com → Empresa B
//  Parâmetro:       ?tenant=slug-da-empresa (para testes)
// ══════════════════════════════════════════════════════════════════
Route::middleware('tenant.loja')->group(function () {
    Route::get('/', [LojaController::class, 'index'])->name('loja.home');
    Route::get('/produto/{id}', [LojaController::class, 'show'])->name('loja.produto');
});

// ══════════════════════════════════════════════════════════════════
//  PAINEL ADMIN — cada empresa gerencia seus próprios dados
// ══════════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {

    // Autenticação (públicas dentro do /admin)
    Route::get('/login',   [LoginController::class, 'index'])->name('login');
    Route::post('/logar',  [LoginController::class, 'logar'])->name('logar');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rotas protegidas — empresa precisa estar autenticada
    Route::middleware('empresa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Produtos
        Route::resource('produtos', ProdutoController::class);

        // CRUD Banners
        Route::resource('banners', BannerController::class);

        // CRUD Categorias
        Route::resource('categorias', CategoriaController::class)->except(['show']);

        // Configurações da loja (nome, cor, logo, domínio, senha...)
        Route::get('/config',          [ConfigController::class, 'index'])->name('config.index');
        Route::put('/config',          [ConfigController::class, 'update'])->name('config.update');
        Route::put('/config/senha',    [ConfigController::class, 'updateSenha'])->name('config.senha');
    });
});
