<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Models\{
    GrupoEconomico,
    Bandeira,
    Unidade,
    Colaborador
};
use App\Observers\AuditoriaObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * O listener para eventos da aplicação.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        //
    ];

    /**
     * Registrar qualquer evento para sua aplicação.
     */
    public function boot(): void
    {
        parent::boot();

        //Registrar o Observer genérico de Auditoria
        GrupoEconomico::observe(AuditoriaObserver::class);
        Bandeira::observe(AuditoriaObserver::class);
        Unidade::observe(AuditoriaObserver::class);
        Colaborador::observe(AuditoriaObserver::class);
    }
}
