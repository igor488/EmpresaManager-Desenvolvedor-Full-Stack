<?php

namespace App\Observers;

use App\Models\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditoriaObserver
{
    private function registrar(Model $model, string $acao)
    {
        Auditoria::create([
            'user_id' => Auth::id(),
            'entidade' => get_class($model),
            'entidade_id' => $model->id,
            'acao' => $acao,
            'dados' => json_encode($model->toArray()),
        ]);
    }

    public function created(Model $model)
    {
        $this->registrar($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->registrar($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->registrar($model, 'deleted');
    }
}
