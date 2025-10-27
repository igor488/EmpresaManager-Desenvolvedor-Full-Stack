<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Auditoria;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class VisualizarAuditorias extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.visualizar-auditorias', [
            'auditorias' => Auditoria::with('user')->latest()->paginate(20)
        ]);
    }
}
