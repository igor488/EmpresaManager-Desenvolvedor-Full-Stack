<?php

namespace App\Observers;

use App\Models\Colaborador;
use Illuminate\Support\Facades\Auth;

class ColaboradorObserver
{
    public function created(Colaborador $colaborador)
    {
        $this->logAuditoria($colaborador, 'created');
    }

    public function updated(Colaborador $colaborador)
    {
        $this->logAuditoria($colaborador, 'updated');
    }

    public function deleted(Colaborador $colaborador)
    {
        $this->logAuditoria($colaborador, 'deleted');
    }

    private function logAuditoria(Colaborador $colaborador, string $acao)
    {
        \App\Models\Auditoria::create([
            'user_id' => Auth::id(),
            'entidade' => get_class($colaborador),
            'entidade_id' => $colaborador->id,
            'acao' => $acao,
            'dados' => json_encode([
                'nome' => $colaborador->nome,
                'email' => $colaborador->email,
                'cpf' => $colaborador->cpf,
                'unidade_id' => $colaborador->unidade_id
            ])
        ]);
    }
}
