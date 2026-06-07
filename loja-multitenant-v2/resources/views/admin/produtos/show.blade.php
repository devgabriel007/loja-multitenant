@extends('admin.layouts.app')
@section('title', 'Produto')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">{{ $produto->nome }}</h5>
                <span class="badge {{ $produto->ativo ? 'bg-success' : 'bg-secondary' }}">{{ $produto->ativo ? 'Ativo' : 'Inativo' }}</span>
            </div>
            <div class="card-body p-4">
                <dl class="row">
                    <dt class="col-sm-3">Nome</dt><dd class="col-sm-9">{{ $produto->nome }}</dd>
                    <dt class="col-sm-3">Descrição</dt><dd class="col-sm-9">{{ $produto->descricao ?: '—' }}</dd>
                    <dt class="col-sm-3">Preço</dt><dd class="col-sm-9">R$ {{ number_format($produto->preco, 2, ',', '.') }}</dd>
                    <dt class="col-sm-3">Estoque</dt><dd class="col-sm-9">{{ $produto->estoque }}</dd>
                </dl>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('admin.produtos.edit', $produto) }}" class="btn btn-primary">Editar</a>
                <a href="{{ route('admin.produtos.index') }}" class="btn btn-outline-secondary">← Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection
