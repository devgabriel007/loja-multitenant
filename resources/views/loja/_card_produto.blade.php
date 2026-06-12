{{-- Partial: card de produto reutilizável na home e destaques --}}
<div class="produto-card card">
    <a href="{{ route('loja.produto', $produto->id) }}" class="text-decoration-none d-block position-relative">
        @if($produto->imagem_url)
            <img src="{{ $produto->imagem_url }}" alt="{{ $produto->nome }}" class="produto-img">
        @else
            <div class="produto-img-placeholder">
                <i class="bi bi-box-seam" style="font-size:2rem;color:#cbd5e1"></i>
            </div>
        @endif

        @if($produto->destaque)
            <span class="badge-destaque position-absolute top-0 start-0 m-2">★ Destaque</span>
        @endif

        @if($produto->preco_antigo && $produto->preco < $produto->preco_antigo)
            @php $pct = round((1 - $produto->preco / $produto->preco_antigo) * 100); @endphp
            <span class="desconto-badge position-absolute top-0 end-0 m-2">-{{ $pct }}%</span>
        @endif
    </a>

    <div class="card-body p-2 d-flex flex-column">
        <div class="mb-1">
            @if($produto->categoria)
                <span style="font-size:.65rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em">
                    {{ $produto->categoria->nome }}
                </span>
            @endif
        </div>

        <a href="{{ route('loja.produto', $produto->id) }}" class="text-decoration-none">
            <div class="produto-nome">{{ $produto->nome }}</div>
        </a>

        <div class="mt-auto pt-2">
            @if($produto->preco_antigo)
                <div class="produto-preco-old">R$ {{ number_format($produto->preco_antigo, 2, ',', '.') }}</div>
            @endif
            <div class="produto-preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>

            <a href="{{ route('loja.produto', $produto->id) }}" class="btn-comprar mt-2">
                Ver produto
            </a>
        </div>
    </div>
</div>
