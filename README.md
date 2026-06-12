# 🛒 Loja Multi-tenant

Plataforma de loja virtual com suporte a **múltiplos tenants (empresas)**, painel admin completo, CRUD de produtos, banners e categorias, e personalização total via interface.

---

## ✨ Funcionalidades

| Área | O que faz |
|---|---|
| **Multi-tenancy** | Cada empresa tem seus próprios dados isolados (produtos, banners, categorias) |
| **Loja pública** | Site com carrossel de banners, filtro por categoria, busca, destaques e página do produto |
| **CRUD Produtos** | Criar, editar, ativar/desativar, marcar destaque, preço com/sem desconto |
| **CRUD Banners** | Título, subtítulo, cor, imagem, link, ordem e prévia em tempo real |
| **CRUD Categorias** | Organização de produtos por categoria |
| **Configurações** | Muda **tudo** da loja: nome, slogan, logo, cor primária, usuário, e-mail, telefone, endereço, domínio, slug e senha |
| **Identidade visual** | Cor primária dinâmica propaga para botões, links e destaques do site |

---

## 🚀 Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/loja-multitenant.git
cd loja-multitenant
```

### 2. Instale as dependências
```bash
composer install
```

### 3. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o banco de dados no `.env`

**MySQL (recomendado para produção):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loja_multitenant
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

**SQLite (desenvolvimento rápido):**
```env
DB_CONNECTION=sqlite
# Deixe DB_DATABASE em branco para usar database/database.sqlite
```
```bash
touch database/database.sqlite
```

### 5. Execute as migrações e seeds
```bash
php artisan migrate --seed
```

Isso cria **duas lojas de exemplo**:
- `TechShop` → usuário: `techshop` | senha: `123456`
- `ModaViva` → usuário: `modaviva` | senha: `123456`

### 6. Inicie o servidor
```bash
php artisan serve
```

---

## 🏪 Como acessar cada loja

O projeto suporta **3 modos** de identificação do tenant (configurado via `TENANT_MODO` no `.env`):

### Modo `porta` (padrão — desenvolvimento)
```bash
php artisan serve --port=8000   # → TechShop
php artisan serve --port=8001   # → ModaViva
```

### Modo `parametro` (qualquer ambiente)
```
http://localhost:8000/?tenant=techshop
http://localhost:8000/?tenant=modaviva
```

### Modo `dominio` (produção)
Configure no `.env`:
```env
TENANT_MODO=dominio
```
E cadastre o domínio de cada empresa no painel em **Configurações → Domínio próprio**.

---

## 🛠️ Painel Admin

Acesse em `/admin/login` e entre com as credenciais da empresa.

| Seção | URL | O que faz |
|---|---|---|
| Dashboard | `/admin/dashboard` | Resumo da loja |
| Produtos | `/admin/produtos` | CRUD completo |
| Categorias | `/admin/categorias` | CRUD completo |
| Banners | `/admin/banners` | CRUD com prévia |
| Configurações | `/admin/config` | Edita tudo da loja |

---

## 🔄 Atualizar via Git (deploy sem acessar o servidor)

Após configurar o servidor com o repositório clonado:

```bash
# No servidor, dentro da pasta do projeto:
git pull origin main

# Se houver novas migrations:
php artisan migrate --force

# Limpar caches:
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> **Dica:** Configure um webhook no GitHub para rodar esses comandos automaticamente a cada `git push`.

---

## 🏗️ Arquitetura Multi-tenancy

```
Requisição → TenantMiddleware
              ↓
           TenantResolver → identifica a Empresa pelo domínio/porta/slug
              ↓
           Loja pública carrega dados da empresa
              
Painel Admin → auth('empresa') → Empresa logada
              ↓
           EmpresaScope → filtra automaticamente WHERE empresa_id = ?
              ↓
           Produtos, Banners, Categorias → isolados por empresa
```

### Para adicionar isolamento a um novo Model:
```php
protected static function booted(): void
{
    static::addGlobalScope(new EmpresaScope);

    static::creating(function (self $model) {
        $model->empresa_id ??= auth('empresa')->id();
    });
}
```
A tabela precisa ter: `$table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();`

---

## 📁 Estrutura do projeto

```
app/
  Http/
    Controllers/
      Admin/        ← LoginController, DashboardController, ProdutoController,
                       BannerController, CategoriaController, ConfigController
      Loja/         ← LojaController (site público)
    Middleware/
      TenantMiddleware.php    ← identifica empresa na loja pública
      EmpresaMiddleware.php   ← protege rotas do painel admin
  Models/
    Empresa.php     ← tenant (autenticável)
    Produto.php     ← usa EmpresaScope
    Banner.php      ← usa EmpresaScope
    Categoria.php   ← usa EmpresaScope
  Scopes/
    EmpresaScope.php          ← WHERE empresa_id automático
  Tenant/
    TenantResolver.php        ← descobre qual empresa serve a requisição
    ManagerEmpresa.php        ← empresa logada no painel

database/
  migrations/       ← empresas, categorias, produtos, banners
  seeders/          ← 2 empresas de exemplo

resources/views/
  admin/            ← layout, login, dashboard, produtos, banners, categorias, config
  loja/             ← home, produto, _card_produto

routes/
  web.php           ← rotas da loja + painel admin
```

---

## 🌐 Deploy em produção

1. Clone o repo no servidor
2. Configure `.env` com MySQL e `APP_ENV=production`
3. Configure `TENANT_MODO=dominio`
4. Aponte o domínio de cada loja para o mesmo servidor
5. Configure nginx/Apache com o `public/` como document root
6. Configure permissões: `chmod -R 775 storage bootstrap/cache`

---

## 📝 Licença

MIT — use à vontade.
