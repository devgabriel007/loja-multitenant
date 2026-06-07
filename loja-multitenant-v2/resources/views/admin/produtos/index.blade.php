@extends('admin.layouts.app')
@section('title', 'Produtos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold mb-0">📦 Produtos</h1>
    <a href="{{ route('admin.produtos.create') }}" class="btn btn-primary">+ Novo Produto</a>
</div>
<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Nome</th><th>Preço</th><th>Estoque</th><th>Status</th><th class="text-end">Ações</th></tr>
            </thead>
            <tbody>
                @forelse($produtos as $produto)
                <tr>
                    <td>
                        <strong>{{ $produto->nome }}</strong>
                        @if($produto->descricao)
                            <br><small class="text-muted">{{ Str::limit($produto->descricao, 60) }}</small>
                        @endif
                    </td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td class="{{ $produto->estoque < 10 ? 'text-danger fw-bold' : '' }}">{{ $produto->estoque }}</td>
                    <td><span class="badge {{ $produto->ativo ? 'bg-success' : 'bg-secondary' }}">{{ $produto->ativo ? 'Ativo' : 'Inativo' }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.produtos.edit', $produto) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="{{ route('admin.produtos.destroy', $produto) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Remover {{ $produto->nome }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-5">Nenhum produto. <a href="{{ route('admin.produtos.create') }}">Criar agora →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($produtos->hasPages())
    <div class="card-footer bg-white">{{ $produtos->links() }}</div>
    @endif
</div>
@endsection
