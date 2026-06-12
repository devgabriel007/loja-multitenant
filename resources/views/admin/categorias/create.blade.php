@extends('admin.layouts.app')
@section('title', 'Nova Categoria')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categorias.index') }}">Categorias</a></li>
    <li class="breadcrumb-item active">Nova</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Nova categoria</h1>
    <a href="{{ route('admin.categorias.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="card" style="max-width:640px">
    <div class="card-body">
        <form action="{{ route('admin.categorias.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-medium">Nome <span class="text-danger">*</span></label>
                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                       value="{{ old('nome') }}" placeholder="Ex: Eletrônicos" required autofocus>
                @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Descrição</label>
                <textarea name="descricao" rows="3" class="form-control @error('descricao') is-invalid @enderror"
                          placeholder="Descrição opcional...">{{ old('descricao') }}</textarea>
                @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1" checked>
                <label class="form-check-label" for="ativo">Categoria ativa</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Salvar categoria
                </button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
