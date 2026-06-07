<?php

namespace App\Tenant;

/**
 * ManagerEmpresa - Resolvedor do Tenant Atual
 * 
 * Responsável por identificar qual empresa (tenant) está autenticada.
 * Reutilizável: basta trocar o guard 'empresa' pelo guard do seu projeto.
 * 
 * Uso: app(ManagerEmpresa::class)->getIdEmpresa()
 */
class ManagerEmpresa
{
    /**
     * Retorna o ID da empresa (tenant) autenticada.
     * Retorna null se nenhuma empresa estiver logada.
     */
    public function getIdEmpresa(): ?int
    {
        return auth('empresa')->user()?->id;
    }

    /**
     * Retorna o objeto completo da empresa autenticada.
     */
    public function getEmpresa(): ?\App\Models\Empresa
    {
        return auth('empresa')->user();
    }

    /**
     * Verifica se há uma empresa autenticada.
     */
    public function isAutenticada(): bool
    {
        return auth('empresa')->check();
    }
}
