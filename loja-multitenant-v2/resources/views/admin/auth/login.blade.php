<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark min-vh-100 d-flex align-items-center justify-content-center">
    <div style="width:100%;max-width:400px;padding:1rem">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="fs-1">🔐</div>
                    <h1 class="h5 fw-bold">Painel Administrativo</h1>
                    <p class="text-muted small">Acesso restrito ao gestor da loja</p>
                </div>

                @if(session('msg_erro'))
                    <div class="alert alert-danger">{{ session('msg_erro') }}</div>
                @endif
                @if(session('msg_sucesso'))
                    <div class="alert alert-success">{{ session('msg_sucesso') }}</div>
                @endif

                <form action="{{ route('admin.logar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Usuário</label>
                        <input type="text" name="usuario" value="{{ old('usuario') }}"
                               class="form-control @error('usuario') is-invalid @enderror"
                               required autofocus placeholder="seu.usuario">
                        @error('usuario')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Senha</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required placeholder="••••••••">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button class="btn btn-primary w-100">Entrar no painel</button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('loja.home') }}" class="text-muted small">← Ver a loja</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
