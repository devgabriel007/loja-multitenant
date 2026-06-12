@extends('admin.layouts.app')
@section('title', 'Categorias')
@section('breadcrumb')
    <li class="breadcrumb-item active">Categorias</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0">Categorias</h1>
        <p class="text-muted small mb-0">{{ $categorias->total() }} categoria(s)</p>
    </div>
    <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
        <i class="bi bi-plus-lg"></i> Nova categoria
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Produtos</th>
                    <th>Status</th>
                    <th style="width:100px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                <tr>
                    <td class="fw-semibold small">{{ $categoria->nome }}</td>
                    <td class="text-muted small">{{ Str::limit($categoria->descricao, 60) ?? '—' }}</td>
                    <td class="small">
                        <span class="badge bg-primary-subtle text-primary">{{ $categoria->produtos_count }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $categoria->ativo ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST"
                                  onsubmit="return confirm('Remover esta categoria? Os produtos não serão apagados.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-tags fs-2 d-block mb-2 opacity-25"></i>
                        Nenhuma categoria cadastrada.
                        <a href="{{ route('admin.categorias.create') }}">Criar a primeira →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categorias->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center py-3">
        {{ $categorias->links() }}
    </div>
    @endif
</div>
@endsection
