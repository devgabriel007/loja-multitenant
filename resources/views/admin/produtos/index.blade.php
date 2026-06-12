@extends('admin.layouts.app')
@section('title', 'Produtos')
@section('breadcrumb')
    <li class="breadcrumb-item active">Produtos</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0">Produtos</h1>
        <p class="text-muted small mb-0">{{ $produtos->total() }} produto(s) cadastrado(s)</p>
    </div>
    <a href="{{ route('admin.produtos.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
        <i class="bi bi-plus-lg"></i> Novo produto
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th style="width:100px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($produtos as $produto)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($produto->imagem_url)
                                <img src="{{ $produto->imagem_url }}" style="width:36px;height:36px;border-radius:6px;object-fit:cover" alt="">
                            @else
                                <div style="width:36px;height:36px;border-radius:6px;background:#f1f5f9;display:flex;align-items:center;justify-content:center">
                                    <i class="bi bi-box-seam text-muted small"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold small">{{ $produto->nome }}</div>
                                @if($produto->destaque)
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:.65rem">
                                        ★ Destaque
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="small text-muted">{{ $produto->categoria?->nome ?? '—' }}</td>
                    <td class="small">
                        <span class="fw-semibold">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                        @if($produto->preco_antigo)
                            <br><span class="text-muted text-decoration-line-through" style="font-size:.7rem">
                                R$ {{ number_format($produto->preco_antigo, 2, ',', '.') }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="small {{ $produto->estoque < 5 ? 'text-danger fw-bold' : '' }}">
                            {{ $produto->estoque }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $produto->ativo ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.produtos.edit', $produto) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.produtos.destroy', $produto) }}" method="POST"
                                  onsubmit="return confirm('Remover este produto?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-box-seam fs-2 d-block mb-2 opacity-25"></i>
                        Nenhum produto cadastrado.
                        <a href="{{ route('admin.produtos.create') }}">Criar o primeiro →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($produtos->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center py-3">
        {{ $produtos->links() }}
    </div>
    @endif
</div>
@endsection
