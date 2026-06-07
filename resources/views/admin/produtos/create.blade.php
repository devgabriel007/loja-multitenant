@extends('admin.layouts.app')
@section('title', 'Novo Produto')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3"><h5 class="mb-0">+ Novo Produto</h5></div>
            <div class="card-body p-4">
                <form action="{{ route('admin.produtos.store') }}" method="POST">
                    @csrf
                    @include('admin.produtos._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('admin.produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
