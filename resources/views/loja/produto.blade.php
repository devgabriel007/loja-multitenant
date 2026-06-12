<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produto->nome }} — {{ $empresa->nome }}</title>
    <meta name="description" content="{{ Str::limit($produto->descricao, 160) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --cor-primaria: {{ $empresa->cor_primaria ?? '#6366f1' }}; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background:#f8fafc; color: #1e293b; }

        .topbar { background: var(--cor-primaria); padding: .85rem 0; }
        .topbar a { color: #fff; text-decoration: none; font-weight: 800; }
        .topbar .brand-desc { color: rgba(255,255,255,.65); font-size: .75rem; }
        .logo-img { width: 36px; height: 36px; border-radius: 8px; object-fit: cover; }

        .produto-img-main {
            width: 100%; aspect-ratio: 1;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,.1);
        }
        .produto-img-placeholder {
            width: 100%; aspect-ratio: 1;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
        }

        .preco-atual { color: var(--cor-primaria); font-size: 2rem; font-weight: 900; }
        .preco-antigo { color: #94a3b8; text-decoration: line-through; font-size: 1rem; }
        .desconto-pill { background: #fef3c7; color: #d97706; font-weight: 700; border-radius: 20px; padding: .2rem .75rem; font-size: .85rem; }

        .badge-estoque-ok   { background: #dcfce7; color: #16a34a; }
        .badge-estoque-low  { background: #fef3c7; color: #d97706; }
        .badge-estoque-zero { background: #fee2e2; color: #dc2626; }

        .btn-principal {
            background: var(--cor-primaria); color: #fff;
            border: none; border-radius: 10px; padding: .75rem 2rem;
            font-weight: 700; font-size: 1rem; transition: opacity .15s;
        }
        .btn-principal:hover { opacity: .88; color: #fff; }
        .btn-outline-primaria {
            border: 2px solid var(--cor-primaria); color: var(--cor-primaria);
            border-radius: 10px; padding: .72rem 1.5rem;
            font-weight: 600; background: transparent; transition: all .15s;
        }
        .btn-outline-primaria:hover { background: var(--cor-primaria); color: #fff; }

        .card-rel { border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.07); transition: transform .2s; height: 100%; }
        .card-rel:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .produto-preco { color: var(--cor-primaria); font-weight: 800; font-size: 1rem; }

        .site-footer { background: #1e293b; color: #94a3b8; padding: 1.5rem 0; margin-top: 3rem; font-size: .85rem; }
        .breadcrumb-item a { color: var(--cor-primaria); }
        .breadcrumb-item.active { color: #64748b; }
    </style>
</head>
<body>

<header class="topbar">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('loja.home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                @if($empresa->logo_url)
                    <img src="{{ $empresa->logo_url }}" class="logo-img" alt="{{ $empresa->nome }}">
                @else
                    <div style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:800;color:#fff">
                        {{ mb_substr($empresa->nome, 0, 1) }}
                    </div>
                @endif
                <span>{{ $empresa->nome }}</span>
            </a>
        </div>
    </div>
</header>

<main class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('loja.home') }}">Início</a></li>
            @if($produto->categoria)
                <li class="breadcrumb-item">
                    <a href="{{ route('loja.home', ['categoria' => $produto->categoria_id]) }}">
                        {{ $produto->categoria->nome }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ Str::limit($produto->nome, 40) }}</li>
        </ol>
    </nav>

    {{-- Produto --}}
    <div class="row g-4 mb-5">
        {{-- Imagem --}}
        <div class="col-md-5">
            @if($produto->imagem_url)
                <img src="{{ $produto->imagem_url }}" alt="{{ $produto->nome }}" class="produto-img-main">
            @else
                <div class="produto-img-placeholder">
                    <i class="bi bi-box-seam" style="font-size:4rem;color:#cbd5e1"></i>
                </div>
            @endif
        </div>

        {{-- Detalhes --}}
        <div class="col-md-7">
            @if($produto->categoria)
                <span style="font-size:.8rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em">
                    {{ $produto->categoria->nome }}
                </span>
            @endif

            <h1 class="h2 fw-bold mt-1 mb-3">{{ $produto->nome }}</h1>

            {{-- Preço --}}
            <div class="d-flex align-items-baseline gap-3 mb-3">
                <span class="preco-atual">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                @if($produto->preco_antigo && $produto->preco < $produto->preco_antigo)
                    <span class="preco-antigo">R$ {{ number_format($produto->preco_antigo, 2, ',', '.') }}</span>
                    @php $pct = round((1 - $produto->preco / $produto->preco_antigo) * 100); @endphp
                    <span class="desconto-pill">-{{ $pct }}% OFF</span>
                @endif
            </div>

            {{-- Estoque --}}
            @php
                $estoqueClass = $produto->estoque > 10 ? 'badge-estoque-ok' : ($produto->estoque > 0 ? 'badge-estoque-low' : 'badge-estoque-zero');
                $estoqueText  = $produto->estoque > 10 ? "Em estoque ({{ $produto->estoque }} unidades)" : ($produto->estoque > 0 ? "Últimas {{ $produto->estoque }} unidades!" : "Esgotado");
            @endphp
            <div class="mb-4">
                <span class="badge {{ $estoqueClass }} px-3 py-2 rounded-pill">
                    <i class="bi bi-{{ $produto->estoque > 0 ? 'check-circle' : 'x-circle' }} me-1"></i>
                    {!! $estoqueText !!}
                </span>
            </div>

            {{-- Descrição --}}
            @if($produto->descricao)
                <div class="mb-4">
                    <h6 class="fw-bold mb-2">Descrição</h6>
                    <p class="text-muted lh-lg">{{ $produto->descricao }}</p>
                </div>
            @endif

            {{-- Botões --}}
            @if($produto->estoque > 0)
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-principal">
                        <i class="bi bi-bag-plus me-1"></i> Adicionar ao carrinho
                    </button>
                    <a href="{{ route('loja.home') }}" class="btn btn-outline-primaria">
                        <i class="bi bi-arrow-left me-1"></i> Continuar comprando
                    </a>
                </div>
            @else
                <div class="alert alert-warning d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Este produto está temporariamente esgotado.</span>
                </div>
                <a href="{{ route('loja.home') }}" class="btn btn-outline-primaria">← Ver outros produtos</a>
            @endif
        </div>
    </div>

    {{-- Produtos relacionados --}}
    @if($relacionados->isNotEmpty())
    <div>
        <h5 class="fw-bold mb-1">Você também pode gostar</h5>
        <div style="width:36px;height:3px;background:var(--cor-primaria);border-radius:2px;margin-bottom:1.25rem"></div>
        <div class="row g-3">
            @foreach($relacionados as $rel)
            <div class="col-6 col-md-3">
                <div class="card-rel card">
                    <a href="{{ route('loja.produto', $rel->id) }}" class="d-block text-decoration-none">
                        @if($rel->imagem_url)
                            <img src="{{ $rel->imagem_url }}" alt="{{ $rel->nome }}"
                                 style="width:100%;aspect-ratio:1;object-fit:cover">
                        @else
                            <div style="width:100%;aspect-ratio:1;background:#f1f5f9;display:flex;align-items:center;justify-content:center">
                                <i class="bi bi-box-seam" style="font-size:1.5rem;color:#cbd5e1"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body p-2">
                        <a href="{{ route('loja.produto', $rel->id) }}" class="text-decoration-none">
                            <div class="fw-semibold small text-dark mb-1" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $rel->nome }}
                            </div>
                        </a>
                        <div class="produto-preco">R$ {{ number_format($rel->preco, 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</main>

<footer class="site-footer">
    <div class="container text-center">
        <div style="color:#f1f5f9;font-weight:700" class="mb-1">{{ $empresa->nome }}</div>
        @if($empresa->telefone)<span class="me-3"><i class="bi bi-telephone me-1"></i>{{ $empresa->telefone }}</span>@endif
        @if($empresa->email)<span><i class="bi bi-envelope me-1"></i>{{ $empresa->email }}</span>@endif
        <div class="mt-2" style="font-size:.75rem">&copy; {{ date('Y') }} {{ $empresa->nome }}</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
