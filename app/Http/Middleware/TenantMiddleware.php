<?php

namespace App\Http\Middleware;

use App\Tenant\TenantResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function __construct(protected TenantResolver $resolver) {}

    public function handle(Request $request, Closure $next): Response
    {
        $empresa = $this->resolver->resolveFromRequest($request);

        if (!$empresa) {
            abort(404, 'Loja não encontrada. Verifique o domínio ou o parâmetro ?tenant=slug.');
        }

        // Compartilha a empresa com todas as views do front-end
        view()->share('empresaAtual', $empresa);

        return $next($request);
    }
}
