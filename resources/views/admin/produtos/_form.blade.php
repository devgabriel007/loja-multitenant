{{-- Partial reutilizado por create.blade.php e edit.blade.php --}}
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-semibold mb-0">Informações</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Nome do produto <span class="text-danger">*</span></label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $produto->nome ?? '') }}" placeholder="Ex: Camiseta Polo Premium" required>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Descrição</label>
                    <textarea name="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror"
                              placeholder="Descreva o produto detalhadamente...">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
                    @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">URL da imagem</label>
                    <input type="url" name="imagem_url" class="form-control @error('imagem_url') is-invalid @enderror"
                           value="{{ old('imagem_url', $produto->imagem_url ?? '') }}" placeholder="https://...">
                    @error('imagem_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Cole a URL pública de uma imagem para exibir no produto.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-semibold mb-0">Preço e estoque</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Preço <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" name="preco" step="0.01" min="0"
                               class="form-control @error('preco') is-invalid @enderror"
                               value="{{ old('preco', $produto->preco ?? '') }}" placeholder="0,00" required>
                        @error('preco')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Preço anterior <span class="text-muted small">(opcional)</span></label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" name="preco_antigo" step="0.01" min="0"
                               class="form-control @error('preco_antigo') is-invalid @enderror"
                               value="{{ old('preco_antigo', $produto->preco_antigo ?? '') }}" placeholder="0,00">
                        @error('preco_antigo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-text">Exibe riscado com indicação de desconto.</div>
                </div>
                <div>
                    <label class="form-label fw-medium">Estoque <span class="text-danger">*</span></label>
                    <input type="number" name="estoque" min="0"
                           class="form-control @error('estoque') is-invalid @enderror"
                           value="{{ old('estoque', $produto->estoque ?? 0) }}" required>
                    @error('estoque')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-semibold mb-0">Organização</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Categoria</label>
                    <select name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror">
                        <option value="">— Sem categoria —</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('categoria_id', $produto->categoria_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h6 class="fw-semibold mb-0">Visibilidade</h6></div>
            <div class="card-body d-flex flex-column gap-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1"
                           {{ old('ativo', $produto->ativo ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativo">Produto ativo (visível na loja)</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="destaque" id="destaque" value="1"
                           {{ old('destaque', $produto->destaque ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="destaque">Produto em destaque</label>
                </div>
            </div>
        </div>
    </div>
</div>
