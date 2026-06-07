<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel Admin') — {{ auth('empresa')->user()->nome ?? '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f1f5f9; }
        .sidebar { width: 240px; min-height: 100vh; background: #1e293b; }
        .sidebar .nav-link { color: #94a3b8; border-radius: 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #334155; color: #fff; }
        .main-content { flex: 1; }
    </style>
</head>
<body>
<div class="d-flex">

    {{-- Sidebar --}}
    <div class="sidebar p-3 d-flex flex-column">
        <div class="text-white fw-bold fs-5 mb-4 px-2">
            🏪 Painel Admin
        </div>
        <nav class="nav flex-column gap-1 flex-grow-1">
            <a class="nav-link px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a class="nav-link px-3 py-2 {{ request()->routeIs('admin.produtos.*') ? 'active' : '' }}"
               href="{{ route('admin.produtos.index') }}">
                <i class="bi bi-box-seam me-2"></i> Produtos
            </a>
            <a class="nav-link px-3 py-2 {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
               href="{{ route('admin.banners.index') }}">
                <i class="bi bi-images me-2"></i> Banners
            </a>
            <hr class="border-secondary">
            <a class="nav-link px-3 py-2" href="{{ route('loja.home') }}" target="_blank">
                <i class="bi bi-shop me-2"></i> Ver loja <i class="bi bi-box-arrow-up-right ms-1 small"></i>
            </a>
        </nav>
        <div class="mt-auto">
            <div class="text-secondary small px-2 mb-2">{{ auth('empresa')->user()->nome }}</div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-1"></i> Sair
                </button>
            </form>
        </div>
    </div>

    {{-- Conteúdo principal --}}
    <div class="main-content p-4">
        @if(session('msg_sucesso'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('msg_sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('msg_erro'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('msg_erro') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
