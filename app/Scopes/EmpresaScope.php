<?php

namespace App\Scopes;

use App\Tenant\ManagerEmpresa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * EmpresaScope - Escopo Global de Isolamento de Tenant
 * 
 * Aplica automaticamente WHERE empresa_id = ? em todas as queries
 * dos Models que utilizarem este scope.
 * 
 * Como reutilizar em outro projeto:
 *   1. Copie este arquivo para app/Scopes/
 *   2. Adicione static::addGlobalScope(new EmpresaScope) no booted() do seu Model
 *   3. Garanta que a tabela possui a coluna empresa_id
 * 
 * Gerado com: php artisan make:scope EmpresaScope
 */
class EmpresaScope implements Scope
{
    /**
     * Aplica o escopo de tenant na query do Eloquent.
     * Só filtra se houver uma empresa autenticada (evita erros em comandos artisan).
     */
    public function apply(Builder $builder, Model $model): void
    {
        $id = app(ManagerEmpresa::class)->getIdEmpresa();

        if ($id) {
            $builder->where('empresa_id', $id);
        }
    }
}
