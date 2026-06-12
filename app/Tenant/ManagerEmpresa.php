<?php

namespace App\Tenant;

use App\Models\Empresa;

/**
 * ManagerEmpresa — Identifica o tenant (empresa) autenticado no painel admin.
 *
 * Usado pelo EmpresaScope para filtrar dados por empresa_id.
 */
class ManagerEmpresa
{
    public function getIdEmpresa(): ?int
    {
        return auth('empresa')->user()?->id;
    }

    public function getEmpresa(): ?Empresa
    {
        return auth('empresa')->user();
    }

    public function isAutenticada(): bool
    {
        return auth('empresa')->check();
    }
}
