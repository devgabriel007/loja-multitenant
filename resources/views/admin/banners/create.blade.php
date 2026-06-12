@extends('admin.layouts.app')
@section('title', 'Novo Banner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
    <li class="breadcrumb-item active">Novo</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Novo banner</h1>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<form action="{{ route('admin.banners.store') }}" method="POST">
    @csrf
    @include('admin.banners._form')
    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Salvar banner
        </button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
