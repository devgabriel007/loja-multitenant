<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Produto;
use App\Scopes\EmpresaScope;
use App\Tenant\TenantResolver;

/**
 * LojaController — Exibe a loja pública do tenant identificado pelo host.
 *
 * O TenantMiddleware já resolveu a empresa antes desta action rodar.
 * Aqui apenas filtramos produtos e banners pelo empresa_id desse tenant.
 */
class LojaController extends Controller
{
    public function __construct(protected TenantResolver $resolver) {}

    public function index()
    {
        $empresa = $this->resolver->getEmpresa();

        $banners = Banner::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('ordem')
            ->get();

        $produtos = Produto::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('nome')
            ->paginate(12);

        return view('loja.home', compact('banners', 'produtos', 'empresa'));
    }

    public function show($id)
    {
        $empresa = $this->resolver->getEmpresa();

        $produto = Produto::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresa->id)
            ->findOrFail($id);

        abort_if(!$produto->ativo, 404);

        return view('loja.produto', compact('produto', 'empresa'));
    }
}
