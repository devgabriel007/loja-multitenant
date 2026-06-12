<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Produto;
use App\Scopes\EmpresaScope;
use App\Tenant\TenantResolver;
use Illuminate\Http\Request;

class LojaController extends Controller
{
    public function __construct(protected TenantResolver $resolver) {}

    public function index(Request $request)
    {
        $empresa = $this->resolver->getEmpresa();

        $banners = Banner::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('ordem')
            ->get();

        $query = Produto::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->where('ativo', true);

        // Filtro por categoria
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Busca por nome
        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }

        $produtos = $query->orderByDesc('destaque')->orderBy('nome')->paginate(12)->withQueryString();

        $categorias = Categoria::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        $destaques = Produto::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->where('destaque', true)
            ->orderBy('nome')
            ->limit(4)
            ->get();

        return view('loja.home', compact('banners', 'produtos', 'empresa', 'categorias', 'destaques'));
    }

    public function show($id)
    {
        $empresa = $this->resolver->getEmpresa();

        $produto = Produto::withoutGlobalScope(EmpresaScope::class)
            ->with('categoria')
            ->where('empresa_id', $empresa->id)
            ->findOrFail($id);

        abort_if(!$produto->ativo, 404);

        $relacionados = Produto::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->where('id', '!=', $produto->id)
            ->when($produto->categoria_id, fn($q) => $q->where('categoria_id', $produto->categoria_id))
            ->limit(4)
            ->get();

        return view('loja.produto', compact('produto', 'empresa', 'relacionados'));
    }
}
