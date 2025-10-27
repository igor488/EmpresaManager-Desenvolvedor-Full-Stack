<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GrupoEconomico;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Grupos extends Component
{
    use WithPagination;

    public $grupo_id, $nome;
    public $isModalOpen = false;

    protected $rules = [
        'nome' => 'required|string|max:255|unique:grupo_economicos,nome',
    ];

    public function render()
    {
        return view('livewire.grupos', [
            'grupos' => GrupoEconomico::latest()->paginate(10)
        ]);
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->grupo_id = null;
        $this->nome = '';
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        try {
            GrupoEconomico::updateOrCreate(['id' => $this->grupo_id], [
                'nome' => $this->nome,
            ]);

            session()->flash('message',
                $this->grupo_id ? 'Grupo atualizado com sucesso!' : 'Grupo criado com sucesso!');

            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao salvar grupo: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $grupo = GrupoEconomico::findOrFail($id);
            $this->grupo_id = $id;
            $this->nome = $grupo->nome;
            $this->openModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Grupo não encontrado');
        }
    }

    public function delete($id)
    {
        try {
            GrupoEconomico::findOrFail($id)->delete();
            session()->flash('message', 'Grupo deletado com sucesso!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao deletar grupo');
        }
    }
}
