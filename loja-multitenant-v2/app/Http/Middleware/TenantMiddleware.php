<?php

namespace App\Http\Middleware;

use App\Tenant\TenantResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * TenantMiddleware — Injeta o tenant correto em cada requisição pública da loja.
 *
 * Registrado em bootstrap/app.php com o alias 'tenant.loja'.
 * Aplicado nas rotas públicas de / e /produto/{id}.
 */
class TenantMiddleware
{
    public function __construct(protected TenantResolver $resolver) {}

    public function handle(Request $request, Closure $next): Response
    {
        $empresa = $this->resolver->resolveFromRequest($request);

        if (!$empresa) {
            abort(404, 'Loja não encontrada para este domínio.');
        }

        // Compartilha $empresaAtual com todas as views automaticamente
        view()->share('empresaAtual', $empresa);

        return $next($request);
    }
}
