<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $empresa->nome }}@if(request('busca')) — Busca: {{ request('busca') }}@endif</title>
    <meta name="description" content="{{ $empresa->descricao ?? $empresa->nome }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --cor-primaria: {{ $empresa->cor_primaria ?? '#6366f1' }};
            --cor-primaria-dark: color-mix(in srgb, var(--cor-primaria) 80%, black);
            --cor-primaria-light: color-mix(in srgb, var(--cor-primaria) 15%, white);
        }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background:#f8fafc; color: #1e293b; }

        /* Topbar */
        .topbar { background: var(--cor-primaria); padding: .85rem 0; }
        .topbar .brand-name { color: #fff; font-weight: 800; font-size: 1.25rem; text-decoration: none; letter-spacing: -.01em; }
        .topbar .brand-desc { color: rgba(255,255,255,.65); font-size: .75rem; }
        .topbar .logo-img { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; }

        /* Search bar */
        .search-bar { background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3); color: #fff; border-radius: 8px; }
        .search-bar::placeholder { color: rgba(255,255,255,.6); }
        .search-bar:focus { background: rgba(255,255,255,.25); border-color: rgba(255,255,255,.6); box-shadow: none; color: #fff; }
        .btn-search { background: rgba(255,255,255,.2); border: none; color: #fff; border-radius: 0 8px 8px 0; transition: background .15s; }
        .btn-search:hover { background: rgba(255,255,255,.35); color: #fff; }

        /* Nav categorias */
        .cat-nav { background: #fff; border-bottom: 1px solid #e2e8f0; }
        .cat-nav .nav-link { color: #475569; font-size: .875rem; padding: .6rem .9rem; border-radius: 6px; transition: all .15s; }
        .cat-nav .nav-link:hover { color: var(--cor-primaria); background: var(--cor-primaria-light); }
        .cat-nav .nav-link.active { color: var(--cor-primaria); font-weight: 600; background: var(--cor-primaria-light); }

        /* Banners */
        .banner-slide {
            border-radius: 14px;
            overflow: hidden;
            position: relative;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 2rem;
        }
        .banner-slide::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,.3) 0%, transparent 60%);
        }
        .banner-slide .banner-content { position: relative; z-index: 1; }
        .banner-slide h2 { font-size: clamp(1.25rem, 3vw, 2rem); font-weight: 800; color: #fff; margin-bottom: .5rem; text-shadow: 0 1px 3px rgba(0,0,0,.3); }
        .banner-slide p { color: rgba(255,255,255,.85); font-size: clamp(.85rem, 2vw, 1.1rem); margin-bottom: 1rem; text-shadow: 0 1px 2px rgba(0,0,0,.2); }
        .banner-cta { display: inline-block; background: #fff; color: #1e293b; padding: .5rem 1.25rem; border-radius: 8px; font-weight: 700; font-size: .875rem; text-decoration: none; transition: transform .15s, box-shadow .15s; }
        .banner-cta:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.2); color: #1e293b; }

        /* Carrossel */
        .carousel-indicators [data-bs-target] { background-color: rgba(255,255,255,.6); border-radius: 50%; width: 8px; height: 8px; }
        .carousel-indicators .active { background-color: #fff; }

        /* Cards produto */
        .produto-card { border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.07); transition: transform .2s, box-shadow .2s; height: 100%; }
        .produto-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
        .produto-img { width: 100%; aspect-ratio: 1; object-fit: cover; background: #f1f5f9; }
        .produto-img-placeholder { width: 100%; aspect-ratio: 1; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); display: flex; align-items: center; justify-content: center; }
        .produto-nome { font-weight: 700; font-size: .95rem; color: #1e293b; margin-bottom: .25rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .produto-preco { color: var(--cor-primaria); font-weight: 800; font-size: 1.1rem; }
        .produto-preco-old { color: #94a3b8; text-decoration: line-through; font-size: .78rem; }
        .desconto-badge { background: #fef3c7; color: #d97706; font-size: .65rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; }
        .btn-comprar {
            background: var(--cor-primaria);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .5rem;
            font-size: .875rem;
            font-weight: 600;
            transition: opacity .15s;
            width: 100%;
            text-decoration: none;
            text-align: center;
            display: block;
        }
        .btn-comprar:hover { opacity: .88; color: #fff; }
        .badge-destaque { background: var(--cor-primaria); color: #fff; font-size: .65rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; }

        /* Section headers */
        .section-title { font-size: 1.1rem; font-weight: 800; color: #1e293b; }
        .section-line { width: 36px; height: 3px; background: var(--cor-primaria); border-radius: 2px; margin-bottom: 1.25rem; }

        /* Footer */
        .site-footer { background: #1e293b; color: #94a3b8; padding: 2rem 0 1rem; margin-top: 3rem; font-size: .85rem; }
        .site-footer .footer-nome { color: #f1f5f9; font-weight: 700; font-size: 1rem; }
        .site-footer a { color: #94a3b8; text-decoration: none; }
        .site-footer a:hover { color: #f1f5f9; }

        /* Empty state */
        .empty-state { text-align: center; padding: 3rem 1rem; }
        .empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; }

        /* Pagination */
        .page-link { color: var(--cor-primaria); }
        .page-item.active .page-link { background: var(--cor-primaria); border-color: var(--cor-primaria); }
    </style>
</head>
<body>

{{-- ── TOPBAR ─────────────────────────────────────────────────── --}}
<header class="topbar">
    <div class="container">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <a href="{{ route('loja.home') }}" class="d-flex align-items-center gap-2 text-decoration-none me-auto">
                @if($empresa->logo_url)
                    <img src="{{ $empresa->logo_url }}" alt="{{ $empresa->nome }}" class="logo-img">
                @else
                    <div style="width:40px;height:40px;border-radius:8px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;color:#fff">
                        {{ mb_substr($empresa->nome, 0, 1) }}
                    </div>
                @endif
                <div>
                    <div class="brand-name">{{ $empresa->nome }}</div>
                    @if($empresa->descricao)
                        <div class="brand-desc d-none d-md-block">{{ $empresa->descricao }}</div>
                    @endif
                </div>
            </a>

            {{-- Barra de busca --}}
            <form action="{{ route('loja.home') }}" method="GET" class="d-flex" style="min-width:220px;max-width:360px;flex:1">
                @if(request('categoria'))
                    <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                @endif
                <input type="search" name="busca" class="form-control search-bar"
                       value="{{ request('busca') }}" placeholder="Buscar produtos...">
                <button type="submit" class="btn btn-search px-3"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</header>

{{-- ── NAVEGAÇÃO CATEGORIAS ────────────────────────────────────── --}}
@if($categorias->isNotEmpty())
<nav class="cat-nav">
    <div class="container">
        <div class="d-flex align-items-center gap-1 overflow-auto py-1" style="scrollbar-width:none">
            <a href="{{ route('loja.home', request()->except('categoria')) }}"
               class="nav-link {{ !request('categoria') ? 'active' : '' }} flex-shrink-0">
                Todos
            </a>
            @foreach($categorias as $cat)
            <a href="{{ route('loja.home', array_merge(request()->except('categoria'), ['categoria' => $cat->id])) }}"
               class="nav-link {{ request('categoria') == $cat->id ? 'active' : '' }} flex-shrink-0">
                {{ $cat->nome }}
            </a>
            @endforeach
        </div>
    </div>
</nav>
@endif

<main class="container py-4">

    {{-- ── BANNERS CARROSSEL ───────────────────────────────────── --}}
    @if($banners->isNotEmpty() && !request('busca') && !request('categoria'))
    <div id="bannersCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            @foreach($banners as $i => $b)
                <button type="button" data-bs-target="#bannersCarousel" data-bs-slide-to="{{ $i }}"
                        class="{{ $i === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($banners as $i => $banner)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <div class="banner-slide"
                     style="background: {{ $banner->cor_fundo }};
                            {{ $banner->imagem_url ? "background-image:url('{$banner->imagem_url}');background-size:cover;background-position:center;" : '' }}">
                    <div class="banner-content">
                        <h2>{{ $banner->titulo }}</h2>
                        @if($banner->subtitulo)
                            <p>{{ $banner->subtitulo }}</p>
                        @endif
                        @if($banner->url_link)
                            <a href="{{ $banner->url_link }}" class="banner-cta">Ver oferta →</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($banners->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#bannersCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannersCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
        @endif
    </div>
    @endif

    {{-- ── DESTAQUES ───────────────────────────────────────────── --}}
    @if($destaques->isNotEmpty() && !request('busca') && !request('categoria'))
    <div class="mb-4">
        <div class="section-title">⭐ Destaques</div>
        <div class="section-line"></div>
        <div class="row g-3">
            @foreach($destaques as $p)
            <div class="col-6 col-md-3">
                @include('loja._card_produto', ['produto' => $p])
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── TODOS OS PRODUTOS ───────────────────────────────────── --}}
    <div class="d-flex align-items-baseline justify-content-between mb-3 gap-2 flex-wrap">
        <div>
            <div class="section-title">
                @if(request('busca'))
                    Resultados para "{{ request('busca') }}"
                @elseif(request('categoria'))
                    {{ $categorias->firstWhere('id', request('categoria'))?->nome ?? 'Categoria' }}
                @else
                    Todos os produtos
                @endif
            </div>
            <div class="section-line"></div>
        </div>
        <span class="text-muted small">{{ $produtos->total() }} produto(s)</span>
    </div>

    @if($produtos->isEmpty())
        <div class="empty-state">
            <i class="bi bi-search d-block"></i>
            <p class="text-muted">Nenhum produto encontrado.</p>
            <a href="{{ route('loja.home') }}" class="btn btn-sm btn-outline-secondary">Ver todos →</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($produtos as $produto)
            <div class="col-6 col-md-4 col-lg-3">
                @include('loja._card_produto')
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $produtos->links() }}
        </div>
    @endif
</main>

{{-- ── FOOTER ──────────────────────────────────────────────────── --}}
<footer class="site-footer">
    <div class="container">
        <div class="row g-3 mb-3">
            <div class="col-md-5">
                <div class="footer-nome mb-1">{{ $empresa->nome }}</div>
                @if($empresa->descricao)
                    <p class="mb-2">{{ $empresa->descricao }}</p>
                @endif
                @if($empresa->telefone)
                    <div><i class="bi bi-telephone me-1"></i> {{ $empresa->telefone }}</div>
                @endif
                @if($empresa->endereco)
                    <div><i class="bi bi-geo-alt me-1"></i> {{ $empresa->endereco }}</div>
                @endif
                @if($empresa->email)
                    <div><i class="bi bi-envelope me-1"></i> {{ $empresa->email }}</div>
                @endif
            </div>
            @if($categorias->isNotEmpty())
            <div class="col-md-3">
                <div class="footer-nome mb-2">Categorias</div>
                @foreach($categorias as $cat)
                    <div><a href="{{ route('loja.home', ['categoria' => $cat->id]) }}">{{ $cat->nome }}</a></div>
                @endforeach
            </div>
            @endif
            <div class="col-md-4">
                <div class="footer-nome mb-2">Acesso rápido</div>
                <div><a href="{{ route('loja.home') }}">Todos os produtos</a></div>
                <div><a href="{{ route('admin.login') }}">Painel admin</a></div>
            </div>
        </div>

        {{-- Banners no rodapé (opcional) --}}
        @if($empresa->banner_rodape && $banners->isNotEmpty())
        <div class="row g-2 mb-3">
            @foreach($banners->take(3) as $banner)
            <div class="col-md-4">
                <div style="border-radius:8px;background:{{ $banner->cor_fundo }};padding:.75rem 1rem;opacity:.7">
                    <div style="color:#fff;font-weight:700;font-size:.8rem">{{ $banner->titulo }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <hr style="border-color:#334155;margin:1rem 0 .75rem">
        <div class="text-center" style="font-size:.75rem">
            &copy; {{ date('Y') }} {{ $empresa->nome }}. Todos os direitos reservados.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
