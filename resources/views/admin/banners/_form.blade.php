{{-- Partial reutilizado por create.blade.php e edit.blade.php --}}
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-semibold mb-0">Conteúdo</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Título <span class="text-danger">*</span></label>
                    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                           value="{{ old('titulo', $banner->titulo ?? '') }}" placeholder="Ex: Nova coleção chegou!" required>
                    @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Subtítulo</label>
                    <input type="text" name="subtitulo" class="form-control @error('subtitulo') is-invalid @enderror"
                           value="{{ old('subtitulo', $banner->subtitulo ?? '') }}" placeholder="Ex: Até 50% de desconto">
                    @error('subtitulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">URL da imagem de fundo</label>
                    <input type="url" name="imagem_url" class="form-control @error('imagem_url') is-invalid @enderror"
                           value="{{ old('imagem_url', $banner->imagem_url ?? '') }}" placeholder="https://...">
                    @error('imagem_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Opcional. Se informada, aparece como fundo do banner.</div>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-medium">Link de destino</label>
                    <input type="url" name="url_link" class="form-control @error('url_link') is-invalid @enderror"
                           value="{{ old('url_link', $banner->url_link ?? '') }}" placeholder="https://...">
                    @error('url_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Opcional. URL que abre ao clicar no banner.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-semibold mb-0">Aparência</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Cor de fundo <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="color" name="cor_fundo" id="cor_fundo"
                               class="form-control form-control-color @error('cor_fundo') is-invalid @enderror"
                               value="{{ old('cor_fundo', $banner->cor_fundo ?? '#1d4ed8') }}">
                        <input type="text" id="cor_fundo_hex" class="form-control font-monospace"
                               value="{{ old('cor_fundo', $banner->cor_fundo ?? '#1d4ed8') }}" maxlength="7" placeholder="#1d4ed8">
                    </div>
                    @error('cor_fundo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Ordem de exibição</label>
                    <input type="number" name="ordem" min="0" class="form-control @error('ordem') is-invalid @enderror"
                           value="{{ old('ordem', $banner->ordem ?? 0) }}">
                    @error('ordem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Menor número = aparece primeiro.</div>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1"
                           {{ old('ativo', $banner->ativo ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativo">Banner ativo</label>
                </div>
            </div>
        </div>

        {{-- Prévia --}}
        <div class="card">
            <div class="card-header"><h6 class="fw-semibold mb-0">Prévia</h6></div>
            <div class="card-body p-2">
                <div id="banner-preview" style="border-radius:8px;padding:1.25rem;background:{{ old('cor_fundo', $banner->cor_fundo ?? '#1d4ed8') }};min-height:80px;display:flex;flex-direction:column;justify-content:center;transition:background .2s;">
                    <div style="color:#fff;font-weight:700;font-size:1rem" id="prev-titulo">{{ old('titulo', $banner->titulo ?? 'Título do Banner') }}</div>
                    <div style="color:rgba(255,255,255,.7);font-size:.8rem" id="prev-subtitulo">{{ old('subtitulo', $banner->subtitulo ?? 'Subtítulo opcional') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const colorInput = document.getElementById('cor_fundo');
const hexInput   = document.getElementById('cor_fundo_hex');
const preview    = document.getElementById('banner-preview');

colorInput.addEventListener('input', () => {
    hexInput.value = colorInput.value;
    preview.style.background = colorInput.value;
});
hexInput.addEventListener('input', () => {
    if (/^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
        colorInput.value = hexInput.value;
        preview.style.background = hexInput.value;
    }
});

document.querySelector('[name=titulo]')?.addEventListener('input', e => {
    document.getElementById('prev-titulo').textContent = e.target.value || 'Título do Banner';
});
document.querySelector('[name=subtitulo]')?.addEventListener('input', e => {
    document.getElementById('prev-subtitulo').textContent = e.target.value || 'Subtítulo opcional';
});
</script>
@endpush
