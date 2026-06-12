<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel') — {{ auth('empresa')->user()->nome ?? 'Admin' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #334155;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #f1f5f9;
            --topbar-height: 0px;
        }
        body { background: #f1f5f9; font-family: 'Segoe UI', system-ui, sans-serif; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .2s;
        }
        .sidebar-brand {
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid #1e293b;
        }
        .sidebar-brand .brand-name {
            font-weight: 700;
            font-size: 1rem;
            color: #f1f5f9;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-brand .brand-sub {
            font-size: .72rem;
            color: #64748b;
            margin-top: 2px;
        }
        .sidebar-nav { padding: .75rem .75rem; flex: 1; overflow-y: auto; }
        .sidebar-nav .nav-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #475569;
            padding: .75rem .5rem .25rem;
        }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            color: var(--sidebar-text);
            padding: .55rem .85rem;
            border-radius: 7px;
            font-size: .875rem;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
        }
        .sidebar-nav .nav-link:hover { background: var(--sidebar-hover); color: var(--sidebar-text-active); }
        .sidebar-nav .nav-link.active { background: var(--sidebar-active); color: #fff; font-weight: 600; }
        .sidebar-nav .nav-link i { font-size: 1rem; flex-shrink: 0; }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #1e293b;
        }
        .sidebar-footer .user-name { color: #94a3b8; font-size: .8rem; margin-bottom: .5rem; }

        /* Main content */
        .main-wrap {
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .main-content { padding: 1.75rem; flex: 1; }

        /* Cards */
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.05); border-radius: 10px; }
        .card-header { background: #fff; border-bottom: 1px solid #f1f5f9; border-radius: 10px 10px 0 0 !important; padding: .9rem 1.25rem; }
        .stat-card { transition: transform .15s; }
        .stat-card:hover { transform: translateY(-2px); }

        /* Alerts */
        .alert { border-radius: 8px; }

        /* Tables */
        .table thead th { font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #64748b; }

        /* Badges */
        .badge { font-weight: 500; }

        /* Mobile toggle */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .sidebar-overlay { display: block !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar overlay (mobile) -->
<div class="sidebar-overlay d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"
     style="z-index:99" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            @php $empresa = auth('empresa')->user(); @endphp
            @if($empresa?->logo_url)
                <img src="{{ $empresa->logo_url }}" alt="Logo" style="width:32px;height:32px;border-radius:6px;object-fit:cover">
            @else
                <div style="width:32px;height:32px;border-radius:6px;background:{{ $empresa?->cor_primaria ?? '#6366f1' }};display:flex;align-items:center;justify-content:center">
                    <span style="color:#fff;font-size:.9rem;font-weight:700">{{ mb_substr($empresa?->nome ?? 'L', 0, 1) }}</span>
                </div>
            @endif
            <div>
                <div class="brand-name">{{ $empresa?->nome ?? 'Painel Admin' }}</div>
                <div class="brand-sub">Painel Admin</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-label">Catálogo</div>
        <a class="nav-link {{ request()->routeIs('admin.produtos.*') ? 'active' : '' }}"
           href="{{ route('admin.produtos.index') }}">
            <i class="bi bi-box-seam"></i> Produtos
        </a>
        <a class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}"
           href="{{ route('admin.categorias.index') }}">
            <i class="bi bi-tags"></i> Categorias
        </a>

        <div class="nav-label">Apresentação</div>
        <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
           href="{{ route('admin.banners.index') }}">
            <i class="bi bi-images"></i> Banners
        </a>

        <div class="nav-label">Loja</div>
        <a class="nav-link {{ request()->routeIs('admin.config.*') ? 'active' : '' }}"
           href="{{ route('admin.config.index') }}">
            <i class="bi bi-gear"></i> Configurações
        </a>
        <a class="nav-link" href="{{ route('loja.home') }}" target="_blank">
            <i class="bi bi-shop"></i> Ver loja <i class="bi bi-box-arrow-up-right ms-auto small"></i>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-name">
            <i class="bi bi-person-circle me-1"></i>{{ $empresa?->nome }}
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-outline-secondary w-100">
                <i class="bi bi-box-arrow-left me-1"></i> Sair
            </button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="main-wrap">
    <div class="main-topbar">
        <button class="btn btn-sm btn-light d-lg-none" onclick="toggleSidebar()">
            <i class="bi bi-list fs-5"></i>
        </button>
        <nav aria-label="breadcrumb" class="ms-1">
            <ol class="breadcrumb mb-0 small">
                @yield('breadcrumb')
            </ol>
        </nav>
        <div class="ms-auto d-flex align-items-center gap-2">
            <a href="{{ route('loja.home') }}" target="_blank" class="btn btn-sm btn-outline-primary d-none d-md-inline-flex align-items-center gap-1">
                <i class="bi bi-shop"></i> Ver loja
            </a>
        </div>
    </div>

    <main class="main-content">
        @if(session('msg_sucesso'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('msg_sucesso') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('msg_erro'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('msg_erro') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('d-none');
}
</script>
@stack('scripts')
</body>
</html>
