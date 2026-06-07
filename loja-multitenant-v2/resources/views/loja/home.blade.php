<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $empresa->nome }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --cor-primaria: {{ $empresa->cor_primaria ?? '#0d6efd' }}; }
        .banner-slide { min-height: 240px; display:flex; align-items:center; justify-content:center; }
        .produto-card { transition: transform .2s, box-shadow .2s; }
        .produto-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12) !important; }
        .navbar-brand { font-weight: 800; letter-spacing: -0.5px; }
        .btn-tenant { background-color: var(--cor-primaria); border-color: var(--cor-primaria); color: #fff; }
        .text-tenant { color: var(--cor-primaria) !important; }
    </style>
</head>
<body class="bg-light">

{{-- Navbar com nome da empresa do tenant --}}
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: {{ $empresa->cor_primaria ?? '#212529' }}">
    <div class="container">
       <a class="navbar-brand" href="{{ route('loja.home') }}">🏪 {{ $empresa->nome }} — Loja Oficial</a>
        <div class="ms-auto">
            <a href="{{ route('admin.login') }}" class="btn btn-outline-light btn-sm">Área admin</a>
        </div>
    </div>
</nav>

{{-- Banners --}}
@if($banners->isNotEmpty())
<div id="carouselBanners" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach($banners as $i => $banner)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <div class="banner-slide text-white text-center px-4"
                 style="background: {{ $banner->cor_fundo }}">
                <div>
                    <h2 class="fw-bold display-5">{{ $banner->titulo }}</h2>
                    @if($banner->subtitulo)
                        <p class="lead opacity-75 mb-3">{{ $banner->subtitulo }}</p>
                    @endif
                    @if($banner->url_link)
                        <a href="{{ $banner->url_link }}" class="btn btn-light btn-lg">Ver mais</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($banners->count() > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanners" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselBanners" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    @endif
</div>
@endif

{{-- Produtos --}}
<div class="container py-5">
    <h2 class="fw-bold mb-4">Produtos de {{ $empresa->nome }}</h2>

    @if($produtos->isEmpty())
        <div class="text-center text-muted py-5">
            <div class="fs-1">📭</div>
            <p>Nenhum produto disponível no momento.</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($produtos as $produto)
            <div class="col">
                <a href="{{ route('loja.produto', $produto->id) }}" class="text-decoration-none text-dark">
                    <div class="card produto-card border-0 shadow-sm h-100 rounded-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-1">{{ $produto->nome }}</h6>
                            @if($produto->descricao)
                                <p class="text-muted small mb-3">{{ Str::limit($produto->descricao, 70) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-tenant fs-5">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </span>
                                @if($produto->estoque > 0)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Em estoque</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Esgotado</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3 px-4">
                            <button class="btn btn-tenant w-100">Ver detalhes</button>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        @if($produtos->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $produtos->links() }}
        </div>
        @endif
    @endif
</div>

<footer class="text-secondary text-center py-4 mt-5 small" style="background: {{ $empresa->cor_primaria ?? '#212529' }}20">
    &copy; {{ date('Y') }} {{ $empresa->nome }} — Todos os direitos reservados
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
