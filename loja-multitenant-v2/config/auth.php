<?php

/**
 * config/auth.php — Configuração Multi-tenancy
 * 
 * Adicione as seções abaixo ao seu arquivo config/auth.php existente.
 * Mantenha o guard 'web' padrão do Laravel intacto.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Guard padrão (não altere — mantém compatibilidade com o Laravel)
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards — Adicione o guard 'empresa' para o Multi-tenancy
    |--------------------------------------------------------------------------
    |
    | 'web'     → guard padrão do Laravel (usuários normais)
    | 'empresa' → guard do tenant (empresas do sistema)
    |
    */
    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // ✅ MULTI-TENANCY: guard da empresa (tenant)
        'empresa' => [
            'driver'   => 'session',
            'provider' => 'empresas',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Providers — Adicione o provider 'empresas'
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        // ✅ MULTI-TENANCY: provider que usa o Model Empresa
        'empresas' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Empresa::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset — opcional para empresas
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'empresas' => [
            'provider' => 'empresas',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
