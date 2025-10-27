<?php

namespace App\Observers;

use App\Models\Grupo;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class GrupoObserver
{
    /**
     * Handle the Grupo "created" event.
     */
    public function created(Grupo $grupo): void
    {
         $this->log('created', $grupo);
    }

    /**
     * Handle the Grupo "updated" event.
     */
    public function updated(Grupo $grupo): void
    {
        $this->log('updated', $grupo);
    }

    /**
     * Handle the Grupo "deleted" event.
     */
    public function deleted(Grupo $grupo): void
    {
         $this->log('deleted', $grupo);
    }

    /**
     * Handle the Grupo "restored" event.
     */
    public function restored(Grupo $grupo): void
    {
        //
    }

    /**
     * Handle the Grupo "force deleted" event.
     */
    public function forceDeleted(Grupo $grupo): void
    {
        //
    }

     protected function log($acao, $modelo)
    {
        Auditoria::create([
            'user_id' => Auth::id() ?? 1,
            'entidade' => get_class($modelo),
            'entidade_id' => $modelo->id,
            'acao' => $acao,
            'dados' => json_encode($modelo->toArray())
        ]);
    }
}
