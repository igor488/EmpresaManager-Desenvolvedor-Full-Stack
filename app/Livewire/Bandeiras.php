<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Bandeiras extends Component
{
    use WithPagination;

    public $nome, $grupo_id, $bandeira_id;
    public $isModalOpen = false;

    protected $rules = [
        'nome' => 'required|string|max:255|unique:bandeiras,nome',
        'grupo_id' => 'required|exists:grupo_economicos,id'
    ];

    public function render()
    {
        return view('livewire.bandeiras', [
            'bandeiras' => Bandeira::with('grupoEconomico')->paginate(10),
            'grupos' => GrupoEconomico::all(),
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
        $this->nome = '';
        $this->grupo_id = null;
        $this->bandeira_id = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        try {
            Bandeira::updateOrCreate(
                ['id' => $this->bandeira_id],
                ['nome' => $this->nome, 'grupo_id' => $this->grupo_id]
            );

            session()->flash('message', $this->bandeira_id ? 'Bandeira atualizada!' : 'Bandeira criada!');
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao salvar bandeira: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $bandeira = Bandeira::findOrFail($id);
            $this->bandeira_id = $id;
            $this->nome = $bandeira->nome;
            $this->grupo_id = $bandeira->grupo_id;
            $this->openModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Bandeira não encontrada');
        }
    }

    public function delete($id)
    {
        try {
            Bandeira::findOrFail($id)->delete();
            session()->flash('message', 'Bandeira excluída!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir bandeira');
        }
    }
}
