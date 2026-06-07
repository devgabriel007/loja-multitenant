@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Dashboard</h1>
        <p class="text-muted small">Bem-vindo, {{ $empresa->nome }}</p>
    </div>
    <a href="{{ route('loja.home') }}" target="_blank" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-shop me-1"></i> Ver loja ao vivo
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1">📦</div>
                <div>
                    <div class="text-muted small">Produtos</div>
                    <div class="fs-3 fw-bold">{{ $totalProdutos }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1">🖼️</div>
                <div>
                    <div class="text-muted small">Banners</div>
                    <div class="fs-3 fw-bold">{{ $totalBanners }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1">🏢</div>
                <div>
                    <div class="text-muted small">Empresa (ID)</div>
                    <div class="fs-3 fw-bold">#{{ $empresa->id }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold">Produtos recentes</h6>
        <a href="{{ route('admin.produtos.create') }}" class="btn btn-primary btn-sm">+ Novo produto</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Nome</th><th>Preço</th><th>Estoque</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($produtosRecentes as $p)
                <tr>
                    <td class="fw-semibold">{{ $p->nome }}</td>
                    <td>R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
                    <td class="{{ $p->estoque < 10 ? 'text-danger fw-bold' : '' }}">{{ $p->estoque }}</td>
                    <td><span class="badge {{ $p->ativo ? 'bg-success' : 'bg-secondary' }}">{{ $p->ativo ? 'Ativo' : 'Inativo' }}</span></td>
                    <td><a href="{{ route('admin.produtos.edit', $p) }}" class="btn btn-sm btn-outline-secondary">Editar</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Nenhum produto ainda. <a href="{{ route('admin.produtos.create') }}">Criar agora →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
