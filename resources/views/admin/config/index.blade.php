@extends('admin.layouts.app')
@section('title', 'Configurações da Loja')
@section('breadcrumb')
    <li class="breadcrumb-item active">Configurações</li>
@endsection

@section('content')
<div class="mb-4">
    <h1 class="h4 fw-bold mb-1">Configurações da loja</h1>
    <p class="text-muted small mb-0">Personalize tudo que aparece no seu site: nome, cor, logo, contato e muito mais.</p>
</div>

<div class="row g-4">
    {{-- Coluna principal --}}
    <div class="col-lg-8">

        {{-- Informações gerais --}}
        <form action="{{ route('admin.config.update') }}" method="POST" class="mb-4">
            @csrf @method('PUT')
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-shop text-primary"></i>
                    <h6 class="fw-semibold mb-0">Informações da loja</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium">Nome da loja <span class="text-danger">*</span></label>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                   value="{{ old('nome', $empresa->nome) }}" placeholder="Ex: Minha Loja Online" required>
                            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Este nome aparece no topo do site, na aba do navegador e em todo o painel.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Usuário de login <span class="text-danger">*</span></label>
                            <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror"
                                   value="{{ old('usuario', $empresa->usuario) }}" required>
                            @error('usuario')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">E-mail <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $empresa->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Descrição / Slogan</label>
                            <textarea name="descricao" rows="2" class="form-control @error('descricao') is-invalid @enderror"
                                      placeholder="Ex: Os melhores produtos com os melhores preços!">{{ old('descricao', $empresa->descricao) }}</textarea>
                            @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Aparece abaixo do nome da loja na página inicial.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Telefone</label>
                            <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror"
                                   value="{{ old('telefone', $empresa->telefone) }}" placeholder="(44) 99999-9999">
                            @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Endereço</label>
                            <input type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror"
                                   value="{{ old('endereco', $empresa->endereco) }}" placeholder="Rua, número, cidade">
                            @error('endereco')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Identidade visual --}}
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-palette text-primary"></i>
                    <h6 class="fw-semibold mb-0">Identidade visual</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium">URL da logo</label>
                            <input type="url" name="logo_url" class="form-control @error('logo_url') is-invalid @enderror"
                                   value="{{ old('logo_url', $empresa->logo_url) }}" placeholder="https://...">
                            @error('logo_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Cole a URL pública da sua logo. Aparece no topo da loja e no painel.</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium">Cor primária <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" name="cor_primaria" id="cor_primaria"
                                       class="form-control form-control-color"
                                       value="{{ old('cor_primaria', $empresa->cor_primaria ?? '#6366f1') }}">
                                <input type="text" id="cor_hex" class="form-control font-monospace @error('cor_primaria') is-invalid @enderror"
                                       value="{{ old('cor_primaria', $empresa->cor_primaria ?? '#6366f1') }}" maxlength="7">
                            </div>
                            @error('cor_primaria')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            <div class="form-text">Define botões, links e destaques em todo o site.</div>
                        </div>
                        <div class="col-md-7 d-flex align-items-end">
                            {{-- Prévia da cor --}}
                            <div id="cor-preview" class="rounded p-3 text-white w-100 text-center fw-bold"
                                 style="background:{{ old('cor_primaria', $empresa->cor_primaria ?? '#6366f1') }};transition:background .2s;border-radius:8px">
                                Prévia da cor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Multi-tenancy / Acesso --}}
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-globe text-primary"></i>
                    <h6 class="fw-semibold mb-0">Acesso à loja (Multi-tenancy)</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Slug (acesso por parâmetro)</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted small">?tenant=</span>
                                <input type="text" name="slug" class="form-control font-monospace @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $empresa->slug) }}" placeholder="minha-loja">
                            </div>
                            @error('slug')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            <div class="form-text">Permite acessar via <code>/?tenant={{ $empresa->slug ?? 'seu-slug' }}</code></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Domínio próprio (produção)</label>
                            <input type="text" name="dominio" class="form-control font-monospace @error('dominio') is-invalid @enderror"
                                   value="{{ old('dominio', $empresa->dominio) }}" placeholder="minha-loja.com.br">
                            @error('dominio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Em produção, configure <code>TENANT_MODO=dominio</code> no .env</div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="banner_rodape" id="banner_rodape" value="1"
                                       {{ old('banner_rodape', $empresa->banner_rodape) ? 'checked' : '' }}>
                                <label class="form-check-label" for="banner_rodape">
                                    Exibir banners também no rodapé da loja
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Salvar configurações
                </button>
            </div>
        </form>
    </div>

    {{-- Coluna lateral --}}
    <div class="col-lg-4">
        {{-- Prévia da loja --}}
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-eye text-primary"></i>
                <h6 class="fw-semibold mb-0">Prévia da loja</h6>
            </div>
            <div class="card-body p-0 overflow-hidden" style="border-radius:0 0 10px 10px">
                <div id="loja-preview" style="background:{{ $empresa->cor_primaria ?? '#6366f1' }};padding:1.25rem;transition:background .2s">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        @if($empresa->logo_url)
                            <img src="{{ $empresa->logo_url }}" style="width:28px;height:28px;border-radius:4px;object-fit:cover">
                        @else
                            <div id="prev-logo-char" style="width:28px;height:28px;border-radius:4px;background:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.8rem">
                                {{ mb_substr($empresa->nome, 0, 1) }}
                            </div>
                        @endif
                        <span id="prev-nome" style="color:#fff;font-weight:700;font-size:.9rem">{{ $empresa->nome }}</span>
                    </div>
                    <div id="prev-desc" style="color:rgba(255,255,255,.7);font-size:.72rem">{{ $empresa->descricao ?? 'Descrição da loja' }}</div>
                </div>
                <div class="p-3 bg-white">
                    <div class="d-flex gap-2 mb-2">
                        <div style="flex:2;background:#f8fafc;border-radius:4px;padding:.4rem .6rem;font-size:.7rem;color:#64748b">Buscar produtos...</div>
                        <div id="prev-btn" style="flex:1;border-radius:4px;padding:.4rem;font-size:.7rem;color:#fff;text-align:center;background:{{ $empresa->cor_primaria ?? '#6366f1' }};transition:background .2s">Buscar</div>
                    </div>
                    <div class="d-flex gap-2">
                        @foreach([1,2,3] as $i)
                        <div style="flex:1;border-radius:6px;border:1px solid #f1f5f9;padding:.5rem;font-size:.65rem;color:#374151">
                            <div style="background:#f1f5f9;height:32px;border-radius:4px;margin-bottom:.3rem"></div>
                            <div style="font-size:.6rem;color:#94a3b8;margin-bottom:.2rem">Produto</div>
                            <div id="prev-preco-{{ $i }}" style="color:{{ $empresa->cor_primaria ?? '#6366f1' }};font-weight:700;font-size:.7rem;transition:color .2s">R$ 99,90</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Trocar senha --}}
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-key text-primary"></i>
                <h6 class="fw-semibold mb-0">Alterar senha</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.config.senha') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nova senha <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Mínimo 8 caracteres">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Confirmar senha <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a nova senha">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="bi bi-key me-1"></i> Alterar senha
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const corInput = document.getElementById('cor_primaria');
const hexInput = document.getElementById('cor_hex');
const corPreview  = document.getElementById('cor-preview');
const lojaPreview = document.getElementById('loja-preview');
const prevBtn     = document.getElementById('prev-btn');

function updateCor(cor) {
    corPreview.style.background  = cor;
    lojaPreview.style.background = cor;
    if (prevBtn) prevBtn.style.background = cor;
    document.querySelectorAll('[id^="prev-preco-"]').forEach(el => el.style.color = cor);
}

corInput?.addEventListener('input', () => { hexInput.value = corInput.value; updateCor(corInput.value); });
hexInput?.addEventListener('input', () => {
    if (/^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
        corInput.value = hexInput.value; updateCor(hexInput.value);
    }
});

document.querySelector('[name=nome]')?.addEventListener('input', e => {
    const el = document.getElementById('prev-nome');
    const lc = document.getElementById('prev-logo-char');
    if (el) el.textContent = e.target.value || 'Nome da loja';
    if (lc) lc.textContent = (e.target.value || 'L').charAt(0).toUpperCase();
});

document.querySelector('[name=descricao]')?.addEventListener('input', e => {
    const el = document.getElementById('prev-desc');
    if (el) el.textContent = e.target.value || 'Descrição da loja';
});
</script>
@endpush
@endsection
