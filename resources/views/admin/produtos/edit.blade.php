@extends('admin.layouts.app')
@section('title', 'Editar Produto')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.produtos.index') }}">Produtos</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0">Editar produto</h1>
        <p class="text-muted small mb-0">{{ $produto->nome }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('loja.produto', $produto->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-eye me-1"></i> Ver na loja
        </a>
        <a href="{{ route('admin.produtos.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>
</div>

<form action="{{ route('admin.produtos.update', $produto) }}" method="POST">
    @csrf @method('PUT')
    @include('admin.produtos._form')
    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Salvar alterações
        </button>
        <a href="{{ route('admin.produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
