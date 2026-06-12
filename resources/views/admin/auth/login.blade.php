<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Painel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0,0,0,.35);
            padding: 2.5rem;
        }
        .login-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: #fff;
            margin-bottom: 1.5rem;
        }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(99,102,241,.2); border-color: #6366f1; }
        .btn-login {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none; color: #fff; font-weight: 600;
            padding: .65rem;
            border-radius: 8px;
            transition: opacity .2s;
        }
        .btn-login:hover { opacity: .9; color: #fff; }
        .form-label { font-size: .875rem; font-weight: 500; color: #374151; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-icon"><i class="bi bi-shop-window"></i></div>
    <h1 class="h4 fw-bold mb-1">Painel Admin</h1>
    <p class="text-muted small mb-4">Entre com suas credenciais para gerenciar sua loja.</p>

    @if(session('msg_erro'))
        <div class="alert alert-danger d-flex align-items-center gap-2 py-2 small">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('msg_erro') }}
        </div>
    @endif
    @if(session('msg_sucesso'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-2 small">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('msg_sucesso') }}
        </div>
    @endif

    <form action="{{ route('admin.logar') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person text-muted"></i></span>
                <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror"
                       value="{{ old('usuario') }}" placeholder="seu-usuario" autofocus>
                @error('usuario')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4 d-flex align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="lembrar" id="lembrar">
                <label class="form-check-label small text-muted" for="lembrar">Lembrar-me</label>
            </div>
        </div>
        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-arrow-right-circle me-2"></i>Entrar no painel
        </button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
