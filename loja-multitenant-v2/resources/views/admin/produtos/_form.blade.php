@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif
<div class="mb-3">
    <label class="form-label fw-semibold">Nome *</label>
    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
           value="{{ old('nome', $produto->nome ?? '') }}" required>
    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Descrição</label>
    <textarea name="descricao" class="form-control" rows="3">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Preço (R$) *</label>
        <input type="number" name="preco" step="0.01" min="0"
               class="form-control @error('preco') is-invalid @enderror"
               value="{{ old('preco', $produto->preco ?? '') }}" required>
        @error('preco')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Estoque *</label>
        <input type="number" name="estoque" min="0"
               class="form-control @error('estoque') is-invalid @enderror"
               value="{{ old('estoque', $produto->estoque ?? 0) }}" required>
        @error('estoque')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="form-check">
    <input type="hidden" name="ativo" value="0">
    <input type="checkbox" name="ativo" value="1" class="form-check-input" id="ativo"
           {{ old('ativo', $produto->ativo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="ativo">Produto ativo (visível na loja)</label>
</div>
