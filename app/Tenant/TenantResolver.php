<?php

namespace App\Tenant;

use App\Models\Empresa;
use Illuminate\Http\Request;

/**
 * TenantResolver — Identifica qual empresa (tenant) serve a requisição pública.
 *
 * Suporta 3 modos configuráveis via .env (TENANT_MODO):
 *   "porta"     → php artisan serve (8000=empresa_a, 8001=empresa_b)
 *   "dominio"   → loja-a.com → empresa com dominio='loja-a.com'
 *   "parametro" → ?tenant=slug-da-empresa na URL (útil para testes)
 *
 * Em produção, configure TENANT_MODO=dominio e defina o campo `dominio`
 * em cada empresa via /admin/config.
 */
class TenantResolver
{
    protected ?Empresa $empresa = null;

    public function resolveFromRequest(Request $request): ?Empresa
    {
        if ($this->empresa) {
            return $this->empresa;
        }

        $modo = env('TENANT_MODO', 'porta');

        // Modo parâmetro: ?tenant=slug
        if ($request->query('tenant')) {
            session(['tenant_slug' => $request->query('tenant')]);
        }
        if (session('tenant_slug')) {
            $this->empresa = Empresa::where('slug', session('tenant_slug'))
                ->where('ativo', true)->first();
            if ($this->empresa) {
                return $this->empresa;
            }
        }

        // Modo domínio (produção)
        if ($modo === 'dominio') {
            $this->empresa = Empresa::where('dominio', $request->getHost())
                ->where('ativo', true)->first();
            return $this->empresa;
        }

        // Modo porta (desenvolvimento: 8000 → 1ª empresa, 8001 → 2ª empresa)
        $port = (string) $request->getPort();
        $this->empresa = match ($port) {
            '8001'  => Empresa::where('ativo', true)->skip(1)->first(),
            '8002'  => Empresa::where('ativo', true)->skip(2)->first(),
            default => Empresa::where('ativo', true)->first(),
        };

        return $this->empresa;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(Empresa $empresa): void
    {
        $this->empresa = $empresa;
    }
}
