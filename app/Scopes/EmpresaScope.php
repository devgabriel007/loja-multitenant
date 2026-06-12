<?php

namespace App\Scopes;

use App\Tenant\ManagerEmpresa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * EmpresaScope — Escopo Global de Isolamento Multi-tenant
 *
 * Aplica automaticamente WHERE empresa_id = ? em todas as queries
 * dos Models que usarem este scope. Garante isolamento total de dados.
 *
 * Como usar em um novo Model:
 *   protected static function booted(): void
 *   {
 *       static::addGlobalScope(new EmpresaScope);
 *   }
 *
 * A tabela DEVE ter a coluna: empresa_id UNSIGNED BIGINT NOT NULL
 */
class EmpresaScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $id = app(ManagerEmpresa::class)->getIdEmpresa();

        if ($id) {
            $builder->where('empresa_id', $id);
        }
    }
}
