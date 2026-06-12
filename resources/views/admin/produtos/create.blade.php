@extends('admin.layouts.app')
@section('title', 'Novo Produto')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.produtos.index') }}">Produtos</a></li>
    <li class="breadcrumb-item active">Novo</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Novo produto</h1>
    <a href="{{ route('admin.produtos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<form action="{{ route('admin.produtos.store') }}" method="POST">
    @csrf
    @include('admin.produtos._form')
    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Salvar produto
        </button>
        <a href="{{ route('admin.produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
