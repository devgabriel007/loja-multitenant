@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<div class="mb-3">
    <label class="form-label fw-semibold">Título *</label>
    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
           value="{{ old('titulo', $banner->titulo ?? '') }}" required>
    @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Subtítulo</label>
    <input type="text" name="subtitulo" class="form-control"
           value="{{ old('subtitulo', $banner->subtitulo ?? '') }}" placeholder="Texto menor abaixo do título">
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Link (URL)</label>
    <input type="url" name="url_link" class="form-control"
           value="{{ old('url_link', $banner->url_link ?? '') }}" placeholder="https://...">
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Cor de fundo</label>
        <div class="d-flex align-items-center gap-2">
            <input type="color" name="cor_fundo" class="form-control form-control-color"
                   value="{{ old('cor_fundo', $banner->cor_fundo ?? '#1d4ed8') }}">
            <span class="text-muted small">Escolha a cor do banner</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Ordem</label>
        <input type="number" name="ordem" min="0" class="form-control"
               value="{{ old('ordem', $banner->ordem ?? 0) }}">
    </div>
</div>
<div class="form-check">
    <input type="hidden" name="ativo" value="0">
    <input type="checkbox" name="ativo" value="1" class="form-check-input" id="ativo"
           {{ old('ativo', $banner->ativo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="ativo">Banner ativo (visível na loja)</label>
</div>
