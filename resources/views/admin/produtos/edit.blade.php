@extends('admin.layouts.app')
@section('title', 'Editar Produto')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3"><h5 class="mb-0">✏️ Editar: {{ $produto->nome }}</h5></div>
            <div class="card-body p-4">
                <form action="{{ route('admin.produtos.update', $produto) }}" method="POST">
                    @csrf @method('PUT')
                    @include('admin.produtos._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                        <a href="{{ route('admin.produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
