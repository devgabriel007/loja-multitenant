<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produto->nome }} — {{ $empresa->nome }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --cor-primaria: {{ $empresa->cor_primaria ?? '#0d6efd' }}; }
        .text-tenant { color: var(--cor-primaria) !important; }
        .btn-tenant { background-color: var(--cor-primaria); border-color: var(--cor-primaria); color: #fff; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark shadow-sm" style="background: {{ $empresa->cor_primaria ?? '#212529' }}">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('loja.home') }}">🛍️ {{ $empresa->nome }}</a>
    </div>
</nav>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('loja.home') }}">{{ $empresa->nome }}</a></li>
            <li class="breadcrumb-item active">{{ $produto->nome }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5">
                    <h1 class="h2 fw-bold mb-2">{{ $produto->nome }}</h1>

                    @if($produto->descricao)
                        <p class="text-muted mb-4">{{ $produto->descricao }}</p>
                    @endif

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="display-6 fw-bold text-tenant">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </span>
                        @if($produto->estoque > 0)
                            <span class="badge bg-success fs-6">{{ $produto->estoque }} em estoque</span>
                        @else
                            <span class="badge bg-danger fs-6">Esgotado</span>
                        @endif
                    </div>

                    <a href="{{ route('loja.home') }}" class="btn btn-outline-secondary">
                        ← Voltar para a loja
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
