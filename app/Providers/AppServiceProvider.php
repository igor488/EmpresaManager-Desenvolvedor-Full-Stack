<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use App\Models\Unidade;
use App\Models\Colaborador;
use App\Observers\AuditoriaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        GrupoEconomico::observe(AuditoriaObserver::class);
        Bandeira::observe(AuditoriaObserver::class);
        Unidade::observe(AuditoriaObserver::class);
        Colaborador::observe(AuditoriaObserver::class);
    }
}
