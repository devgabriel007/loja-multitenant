<?php
/**
 * DIAGNÓSTICO MULTI-TENANCY
 * Acesse: http://localhost:8000/diagnostico.php
 *         http://localhost:8001/diagnostico.php
 *
 * Prova que é o mesmo código e mesmo banco servindo dois sites diferentes.
 */

// Carrega o .env manualmente (sem bootstrap do Laravel)
$envPath = __DIR__ . '/../.env';
$env = [];
if (file_exists($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $val] = explode('=', $line, 2);
        $env[trim($key)] = trim($val, " \t\n\r\0\x0B\"'");
    }
}

$host  = $env['DB_HOST']     ?? '127.0.0.1';
$port  = $env['DB_PORT']     ?? '3306';
$db    = $env['DB_DATABASE'] ?? 'loja_multitenant';
$user  = $env['DB_USERNAME'] ?? 'root';
$pass  = $env['DB_PASSWORD'] ?? '';
$conn  = $env['DB_CONNECTION'] ?? 'sqlite';

$portaServidor = $_SERVER['SERVER_PORT'] ?? '?';
$tenantEsperado = ($portaServidor == '8001') ? 'empresa_b (Café Gourmet ME)' : 'empresa_a (Tech Solutions Ltda)';
$corTenant = ($portaServidor == '8001') ? '#92400e' : '#1d4ed8';

$pdo = null;
$erro = null;
try {
    if ($conn === 'mysql') {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    } else {
        $sqlitePath = __DIR__ . '/../database/database.sqlite';
        $pdo = new PDO("sqlite:$sqlitePath");
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    $erro = $e->getMessage();
}

function query($pdo, $sql) {
    if (!$pdo) return [];
    try { return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); } catch(Exception $e) { return []; }
}

$empresas = query($pdo, "SELECT id, nome, usuario, cor_primaria, dominio, ativo FROM empresas ORDER BY id");
$produtos  = query($pdo, "SELECT p.id, e.nome as empresa, e.cor_primaria, p.nome as produto, p.preco, p.empresa_id FROM produtos p JOIN empresas e ON e.id = p.empresa_id ORDER BY p.empresa_id, p.id");
$banners   = query($pdo, "SELECT b.id, e.nome as empresa, b.titulo, b.cor_fundo, b.empresa_id FROM banners b JOIN empresas e ON e.id = b.empresa_id ORDER BY b.empresa_id, b.id");

// Detecta qual empresa este servidor serve
$empresaAtual = null;
foreach ($empresas as $emp) {
    if ($portaServidor == '8001' && $emp['usuario'] === 'empresa_b') $empresaAtual = $emp;
    if ($portaServidor != '8001' && $emp['usuario'] === 'empresa_a') $empresaAtual = $emp;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Diagnóstico Multi-tenancy</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background: #f8f9fa; }
    .tenant-badge { font-size: 1.1rem; padding: .5rem 1.2rem; border-radius: 2rem; color: #fff; display:inline-block; }
    .proof-box { border-left: 4px solid; padding: 1rem 1.5rem; background: #fff; border-radius: 0 .5rem .5rem 0; }
    .highlight { background: #fff3cd; font-weight: bold; }
    th { white-space: nowrap; }
</style>
</head>
<body>
<div class="container py-5">

    <h1 class="fw-bold mb-1">🔍 Diagnóstico Multi-tenancy</h1>
    <p class="text-muted mb-4">Prova que dois servidores usam o mesmo banco e mesmo código</p>

    <?php if ($erro): ?>
    <div class="alert alert-danger">❌ Erro de conexão: <?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <!-- SERVIDOR ATUAL -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">📡 Este Servidor</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 rounded-3 bg-light text-center">
                        <div class="text-muted small">Porta</div>
                        <div class="fs-2 fw-bold"><?= $portaServidor ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-3 text-white text-center" style="background:<?= $corTenant ?>">
                        <div class="small opacity-75">Tenant servido</div>
                        <div class="fw-bold"><?= $tenantEsperado ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-3 bg-light text-center">
                        <div class="text-muted small">Banco</div>
                        <div class="fw-bold"><?= strtoupper($conn) ?>: <?= $db ?></div>
                        <div class="text-success small"><?= $pdo ? '✅ Conectado' : '❌ Erro' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PROVA 1: MESMO ARQUIVO DE CÓDIGO -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-1">📄 Prova 1 — Mesmo Arquivo de Código</h5>
            <p class="text-muted small mb-3">O arquivo abaixo é idêntico nos dois servidores. A porta decide quem é quem.</p>
            <div class="proof-box" style="border-color:#6f42c1; background:#f8f5ff">
                <code class="d-block mb-1 text-muted">// app/Tenant/TenantResolver.php</code>
                <pre class="mb-0" style="font-size:.85rem">$port = (string) $request->getPort();

$this->empresa = <strong>match ($port)</strong> {
    <span style="color:#92400e"><strong>'8001'</strong></span>  => Empresa::where('usuario', 'empresa_b')->first(), <span class="text-muted">// ← Café Gourmet</span>
    <span style="color:#1d4ed8">default</span> => Empresa::where('usuario', 'empresa_a')->first(), <span class="text-muted">// ← Tech Solutions</span>
};</pre>
                <div class="mt-2 p-2 rounded" style="background:#ede9fe">
                    <strong>Resultado agora:</strong> porta <code><?= $portaServidor ?></code> → carregou
                    <span class="tenant-badge ms-1" style="background:<?= $corTenant ?>"><?= $empresaAtual['nome'] ?? '?' ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- PROVA 2: MESMO BANCO -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-1">🗄️ Prova 2 — Mesmo Banco de Dados</h5>
            <p class="text-muted small mb-3">Todas as empresas estão na mesma tabela <code>empresas</code>, separadas só por <code>id</code>.</p>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-dark">
                    <tr><th>id</th><th>nome</th><th>usuario</th><th>cor_primaria</th><th>dominio</th><th>ativo</th><th>Este servidor?</th></tr>
                </thead>
                <tbody>
                <?php foreach ($empresas as $e): $isAtual = $empresaAtual && $e['id'] == $empresaAtual['id']; ?>
                <tr class="<?= $isAtual ? 'highlight' : '' ?>">
                    <td><?= $e['id'] ?></td>
                    <td><?= htmlspecialchars($e['nome']) ?></td>
                    <td><code><?= $e['usuario'] ?></code></td>
                    <td>
                        <span class="badge text-white" style="background:<?= $e['cor_primaria'] ?>"><?= $e['cor_primaria'] ?></span>
                    </td>
                    <td><?= $e['dominio'] ?? '-' ?></td>
                    <td><?= $e['ativo'] ? '✅' : '❌' ?></td>
                    <td><?= $isAtual ? '<strong>👈 SIM</strong>' : '<span class="text-muted">não</span>' ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- PROVA 3: PRODUTOS ISOLADOS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-1">📦 Prova 3 — Produtos Isolados por <code>empresa_id</code></h5>
            <p class="text-muted small mb-3">Todos os produtos estão na mesma tabela. O <code>EmpresaScope</code> filtra automaticamente pelo tenant do servidor.</p>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-dark">
                    <tr><th>id</th><th>empresa_id</th><th>empresa</th><th>produto</th><th>preço</th><th>Visível neste servidor?</th></tr>
                </thead>
                <tbody>
                <?php foreach ($produtos as $p):
                    $visivel = $empresaAtual && $p['empresa_id'] == $empresaAtual['id'];
                ?>
                <tr class="<?= $visivel ? 'highlight' : 'text-muted' ?>">
                    <td><?= $p['id'] ?></td>
                    <td><span class="badge text-white" style="background:<?= $p['cor_primaria'] ?>"><?= $p['empresa_id'] ?></span></td>
                    <td><?= htmlspecialchars($p['empresa']) ?></td>
                    <td><?= htmlspecialchars($p['produto']) ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td><?= $visivel ? '✅ <strong>SIM</strong>' : '🚫 filtrado' ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <div class="alert alert-info mb-0 mt-2">
                <strong>Como funciona:</strong> <code>EmpresaScope</code> adiciona automaticamente <code>WHERE empresa_id = <?= $empresaAtual['id'] ?? '?' ?></code> em toda query deste servidor.
            </div>
        </div>
    </div>

    <!-- PROVA 4: BANNERS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-1">🖼️ Prova 4 — Banners Isolados</h5>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-dark">
                    <tr><th>id</th><th>empresa_id</th><th>empresa</th><th>título</th><th>cor_fundo</th><th>Visível neste servidor?</th></tr>
                </thead>
                <tbody>
                <?php foreach ($banners as $b):
                    $visivel = $empresaAtual && $b['empresa_id'] == $empresaAtual['id'];
                ?>
                <tr class="<?= $visivel ? 'highlight' : 'text-muted' ?>">
                    <td><?= $b['id'] ?></td>
                    <td><span class="badge text-white" style="background:<?= $b['cor_fundo'] ?>"><?= $b['empresa_id'] ?></span></td>
                    <td><?= htmlspecialchars($b['empresa']) ?></td>
                    <td><?= htmlspecialchars($b['titulo']) ?></td>
                    <td><span class="badge text-white" style="background:<?= $b['cor_fundo'] ?>"><?= $b['cor_fundo'] ?></span></td>
                    <td><?= $visivel ? '✅ <strong>SIM</strong>' : '🚫 filtrado' ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- LINKS RÁPIDOS -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">🔗 Acesse os dois sites</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded-3 text-white" style="background:#1d4ed8">
                        <strong>Tech Solutions Ltda</strong><br>
                        <small>localhost:8000</small><br><br>
                        <a href="http://localhost:8000" class="btn btn-light btn-sm me-1" target="_blank">🛍️ Loja</a>
                        <a href="http://localhost:8000/admin/login" class="btn btn-outline-light btn-sm me-1" target="_blank">🔐 Admin</a>
                        <a href="http://localhost:8000/diagnostico.php" class="btn btn-outline-light btn-sm" target="_blank">🔍 Diagnóstico</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-3 text-white" style="background:#92400e">
                        <strong>Café Gourmet ME</strong><br>
                        <small>localhost:8001</small><br><br>
                        <a href="http://localhost:8001" class="btn btn-light btn-sm me-1" target="_blank">🛍️ Loja</a>
                        <a href="http://localhost:8001/admin/login" class="btn btn-outline-light btn-sm me-1" target="_blank">🔐 Admin</a>
                        <a href="http://localhost:8001/diagnostico.php" class="btn btn-outline-light btn-sm" target="_blank">🔍 Diagnóstico</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p class="text-center text-muted small mt-4">
        Este arquivo é <code>public/diagnostico.php</code> — existe em um único lugar, serve os dois servidores.
    </p>
</div>
</body>
</html>
