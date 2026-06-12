@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h4 fw-bold mb-1">Dashboard</h1>
        <p class="text-muted small mb-0">Bem-vindo de volta, <strong>{{ $empresa->nome }}</strong></p>
    </div>
    <a href="{{ route('admin.produtos.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
        <i class="bi bi-plus-lg"></i> Novo produto
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:44px;height:44px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi bi-box-seam fs-5 text-purple" style="color:#7c3aed"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:.75rem">Produtos</div>
                    <div class="fs-4 fw-bold lh-1">{{ $totalProdutos }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:44px;height:44px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi bi-tags fs-5" style="color:#16a34a"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:.75rem">Categorias</div>
                    <div class="fs-4 fw-bold lh-1">{{ $totalCategorias }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:44px;height:44px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi bi-images fs-5" style="color:#d97706"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:.75rem">Banners</div>
                    <div class="fs-4 fw-bold lh-1">{{ $totalBanners }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:44px;height:44px;border-radius:10px;background:#e0f2fe;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi bi-palette fs-5" style="color:#0284c7"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:.75rem">Cor da loja</div>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <div style="width:18px;height:18px;border-radius:4px;background:{{ $empresa->cor_primaria ?? '#6366f1' }}"></div>
                        <span class="small fw-bold">{{ $empresa->cor_primaria ?? '#6366f1' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Produtos recentes --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0">Produtos recentes</h6>
                <a href="{{ route('admin.produtos.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produtosRecentes as $p)
                        <tr>
                            <td>
                                <div class="fw-semibold small">{{ $p->nome }}</div>
                                @if($p->categoria)
                                    <div class="text-muted" style="font-size:.72rem">{{ $p->categoria->nome }}</div>
                                @endif
                            </td>
                            <td class="small">
                                R$ {{ number_format($p->preco, 2, ',', '.') }}
                                @if($p->preco_antigo)
                                    <br><span class="text-muted text-decoration-line-through" style="font-size:.7rem">
                                        R$ {{ number_format($p->preco_antigo, 2, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                            <td class="{{ $p->estoque < 5 ? 'text-danger fw-bold' : '' }} small">{{ $p->estoque }}</td>
                            <td>
                                <span class="badge {{ $p->ativo ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                    {{ $p->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.produtos.edit', $p) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4 small">
                                Nenhum produto ainda.
                                <a href="{{ route('admin.produtos.create') }}">Criar agora →</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Info da loja --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0">Sua loja</h6>
                <a href="{{ route('admin.config.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    @if($empresa->logo_url)
                        <img src="{{ $empresa->logo_url }}" style="width:48px;height:48px;border-radius:10px;object-fit:cover" alt="">
                    @else
                        <div style="width:48px;height:48px;border-radius:10px;background:{{ $empresa->cor_primaria }};display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#fff;font-weight:700">
                            {{ mb_substr($empresa->nome, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <div class="fw-bold">{{ $empresa->nome }}</div>
                        <div class="text-muted small">@{{ $empresa->usuario }}</div>
                    </div>
                </div>
                @if($empresa->descricao)
                    <p class="text-muted small mb-3">{{ $empresa->descricao }}</p>
                @endif
                <div class="d-flex flex-column gap-1 small">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope text-muted"></i>
                        <span class="text-muted">{{ $empresa->email }}</span>
                    </div>
                    @if($empresa->telefone)
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-telephone text-muted"></i>
                        <span class="text-muted">{{ $empresa->telefone }}</span>
                    </div>
                    @endif
                    @if($empresa->dominio)
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-globe text-muted"></i>
                        <span class="text-muted">{{ $empresa->dominio }}</span>
                    </div>
                    @endif
                    @if($empresa->slug)
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-link-45deg text-muted"></i>
                        <span class="text-muted">?tenant={{ $empresa->slug }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
