@extends('admin.layouts.app')
@section('title', 'Editar Banner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0">Editar banner</h1>
        <p class="text-muted small mb-0">{{ $banner->titulo }}</p>
    </div>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<form action="{{ route('admin.banners.update', $banner) }}" method="POST">
    @csrf @method('PUT')
    @include('admin.banners._form')
    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Salvar alterações
        </button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
