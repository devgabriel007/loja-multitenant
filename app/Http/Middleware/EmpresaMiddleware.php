<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpresaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('empresa')->check()) {
            return redirect()->route('admin.login')
                ->with('msg_erro', 'Por favor, faça login para continuar.');
        }

        return $next($request);
    }
}
