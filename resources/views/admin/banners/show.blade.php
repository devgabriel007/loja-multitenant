@extends('admin.layouts.app')
@section('title', 'Banner')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="p-5 text-white text-center" style="background:{{ $banner->cor_fundo }}">
                <h2 class="fw-bold">{{ $banner->titulo }}</h2>
                @if($banner->subtitulo)<p class="mb-0 opacity-75">{{ $banner->subtitulo }}</p>@endif
            </div>
            <div class="card-footer bg-white d-flex gap-2 p-3">
                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary">Editar</a>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">← Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection
