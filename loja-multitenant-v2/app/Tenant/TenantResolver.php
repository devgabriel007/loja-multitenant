<?php

namespace App\Tenant;

use App\Models\Empresa;
use Illuminate\Http\Request;

/**
 * TenantResolver — Identifica o tenant pelo host/porta da requisição.
 *
 * Em desenvolvimento local: usa a PORTA para distinguir empresas
 *   porta 8000 → empresa_a (Tech Solutions)
 *   porta 8001 → empresa_b (Café Gourmet)
 *
 * Em produção: usa o DOMÍNIO (campo `dominio` na tabela empresas)
 *   loja-a.com → empresa com dominio = 'loja-a.com'
 *   loja-b.com → empresa com dominio = 'loja-b.com'
 */
class TenantResolver
{
    protected ?Empresa $empresa = null;

    /**
     * Resolve e armazena a empresa para esta requisição.
     */
    public function resolveFromRequest(Request $request): ?Empresa
    {
        if ($this->empresa) {
            return $this->empresa;
        }

        if (app()->isLocal() || app()->environment('testing')) {
            // Em ambiente local: distingue pelo número da porta
            $port = (string) $request->getPort();

            $this->empresa = match ($port) {
                '8001'  => Empresa::where('usuario', 'empresa_b')->where('ativo', true)->first(),
                default => Empresa::where('usuario', 'empresa_a')->where('ativo', true)->first(),
            };
        } else {
            // Em produção: resolve pelo domínio real
            $host = $request->getHost();
            $this->empresa = Empresa::where('dominio', $host)->where('ativo', true)->first();
        }

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
