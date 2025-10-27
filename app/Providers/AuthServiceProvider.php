<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * O mapa de políticas da aplicação.
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Registrar quaisquer serviços de autenticação / autorização.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Exemplo de Gate (caso precise)
        Gate::define('isAdmin', fn($user) => $user->is_admin ?? false);
    }
}
