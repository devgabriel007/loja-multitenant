# 🛍️ Loja Multi-tenancy — Dois Servidores, Um Só Código

## O que foi adicionado nesta versão

| Arquivo novo/alterado | O que faz |
|-----------------------|-----------|
| `app/Tenant/TenantResolver.php` | Identifica a empresa pelo host HTTP (porta local / domínio produção) |
| `app/Http/Middleware/TenantMiddleware.php` | Injeta o tenant em cada requisição pública |
| `app/Providers/AppServiceProvider.php` | Registra `TenantResolver` como singleton |
| `bootstrap/app.php` | Alias `tenant.loja` para o novo middleware |
| `routes/web.php` | Rotas públicas agora usam `middleware('tenant.loja')` |
| `app/Http/Controllers/Loja/LojaController.php` | Filtra produtos/banners pelo tenant resolvido |
| `resources/views/loja/home.blade.php` | Exibe nome e cor da empresa do tenant |
| `resources/views/loja/produto.blade.php` | Idem |
| `database/migrations/2024_01_02_...php` | Adiciona `dominio` e `cor_primaria` à tabela empresas |
| `app/Models/Empresa.php` | Campos `dominio` e `cor_primaria` no fillable |

---

## 🚀 Instalação

```bash
composer install
npm install && npm run build
php artisan migrate
php artisan db:seed --class=MultitenancyTestSeeder
```

---

## 🖥️ Dois servidores locais (dois terminais)

```bash
# Terminal 1 — Tech Solutions (azul)
php artisan serve --port=8000

# Terminal 2 — Café Gourmet (marrom)
php artisan serve --port=8001
```

| URL | Loja | Cor |
|-----|------|-----|
| `http://localhost:8000` | Tech Solutions Ltda | Azul |
| `http://localhost:8001` | Café Gourmet ME | Marrom |

---

## 🔑 Credenciais de Teste

| Usuário | Senha | URL do admin |
|---------|-------|-------------|
| `empresa_a` | `123456` | `localhost:8000/admin/login` |
| `empresa_b` | `123456` | `localhost:8001/admin/login` |

---

## 🌐 Em Produção (dois domínios reais)

Basta popular o campo `dominio` de cada empresa com o domínio real.
O `TenantResolver` em produção usa `$request->getHost()` automaticamente.

| Empresa | Campo `dominio` |
|---------|----------------|
| Tech Solutions | `loja-a.com` |
| Café Gourmet | `loja-b.com` |

O mesmo código roda nos dois servidores — nenhuma duplicação.

---

## Como funciona o isolamento

```
localhost:8000  ──►  TenantMiddleware  ──►  TenantResolver  ──►  empresa_id=1  ──►  dados da Empresa A
localhost:8001  ──►  TenantMiddleware  ──►  TenantResolver  ──►  empresa_id=2  ──►  dados da Empresa B
                              ↑
                        mesmo código
```

## Como adicionar cor_primaria ao admin (opcional)

Adicione um campo `<input type="color">` no form de perfil da empresa
e salve em `empresas.cor_primaria`. A loja já lê esse campo automaticamente.
