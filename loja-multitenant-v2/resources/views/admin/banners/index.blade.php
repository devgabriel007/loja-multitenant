@extends('admin.layouts.app')
@section('title', 'Banners')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold mb-0">🖼️ Banners</h1>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">+ Novo Banner</a>
</div>
<div class="row g-3">
    @forelse($banners as $banner)
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="p-4 text-white" style="background:{{ $banner->cor_fundo }}; min-height: 100px;">
                <h5 class="fw-bold mb-1">{{ $banner->titulo }}</h5>
                @if($banner->subtitulo)
                    <p class="mb-0 opacity-75">{{ $banner->subtitulo }}</p>
                @endif
            </div>
            <div class="card-body d-flex justify-content-between align-items-center py-2 px-3">
                <div>
                    <span class="badge {{ $banner->ativo ? 'bg-success' : 'bg-secondary' }} me-2">{{ $banner->ativo ? 'Ativo' : 'Inativo' }}</span>
                    <span class="text-muted small">Ordem: {{ $banner->ordem }}</span>
                </div>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                          onsubmit="return confirm('Remover banner?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">
        Nenhum banner cadastrado. <a href="{{ route('admin.banners.create') }}">Criar agora →</a>
    </div>
    @endforelse
</div>
@endsection
