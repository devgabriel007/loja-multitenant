<?php

namespace App\Providers;

use App\Tenant\ManagerEmpresa;
use App\Tenant\TenantResolver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Singleton para manter o tenant resolvido durante toda a requisição
        $this->app->singleton(TenantResolver::class);
        $this->app->singleton(ManagerEmpresa::class);
    }

    public function boot(): void
    {
        //
    }
}
