@extends('admin.layouts.app')
@section('title', 'Banners')
@section('breadcrumb')
    <li class="breadcrumb-item active">Banners</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0">Banners</h1>
        <p class="text-muted small mb-0">{{ $banners->count() }} banner(s) cadastrado(s)</p>
    </div>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
        <i class="bi bi-plus-lg"></i> Novo banner
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Prévia</th>
                    <th>Título</th>
                    <th>Subtítulo</th>
                    <th>Ordem</th>
                    <th>Status</th>
                    <th style="width:100px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>
                    <td>
                        <div style="width:64px;height:36px;border-radius:6px;background:{{ $banner->cor_fundo }};overflow:hidden;position:relative;">
                            @if($banner->imagem_url)
                                <img src="{{ $banner->imagem_url }}" style="width:100%;height:100%;object-fit:cover;opacity:.6">
                            @endif
                        </div>
                    </td>
                    <td class="fw-semibold small">{{ $banner->titulo }}</td>
                    <td class="text-muted small">{{ $banner->subtitulo ?? '—' }}</td>
                    <td class="small">{{ $banner->ordem }}</td>
                    <td>
                        <span class="badge {{ $banner->ativo ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ $banner->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                                  onsubmit="return confirm('Remover este banner?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-images fs-2 d-block mb-2 opacity-25"></i>
                        Nenhum banner cadastrado.
                        <a href="{{ route('admin.banners.create') }}">Criar o primeiro →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
