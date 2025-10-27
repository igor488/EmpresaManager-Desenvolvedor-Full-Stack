<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Colaborador;
use App\Models\Unidade;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Colaboradores extends Component
{
    use WithPagination;

    public $nome, $email, $cpf, $unidade_id, $colaborador_id;
    public $isModalOpen = false;

    protected function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:colaboradors,email,' . $this->colaborador_id,
            'cpf' => 'required|string|max:14|unique:colaboradors,cpf,' . $this->colaborador_id,
            'unidade_id' => 'required|exists:unidades,id'
        ];
    }

    public function render()
    {
        return view('livewire.colaboradores', [
            'colaboradores' => Colaborador::with('unidade')->paginate(10),
            'unidades' => Unidade::all(),
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
        $this->email = '';
        $this->cpf = '';
        $this->unidade_id = null;
        $this->colaborador_id = null;
        $this->resetErrorBag();
    }

    public function updatedCpf($value)
    {

        $cpf = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cpf) <= 11) {
            if (strlen($cpf) <= 3) {
                $this->cpf = $cpf;
            } elseif (strlen($cpf) <= 6) {
                $this->cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3);
            } elseif (strlen($cpf) <= 9) {
                $this->cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6);
            } else {
                $this->cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
            }
        }
    }

    public function store()
    {
        // Remove formatação antes de validar
        $cpfSemFormatacao = preg_replace('/[^0-9]/', '', $this->cpf);

        // Validação customizada para garantir o formato correto
        $this->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:colaboradors,email,' . $this->colaborador_id,
            'cpf' => [
                'required',
                'string',
                'max:14',
                'unique:colaboradors,cpf,' . $this->colaborador_id,
                function ($attribute, $value, $fail) use ($cpfSemFormatacao) {
                    if (strlen($cpfSemFormatacao) !== 11) {
                        $fail('O CPF deve conter 11 dígitos.');
                    }
                }
            ],
            'unidade_id' => 'required|exists:unidades,id'
        ]);

        try {
            Colaborador::updateOrCreate(
                ['id' => $this->colaborador_id],
                [
                    'nome' => $this->nome,
                    'email' => $this->email,
                    'cpf' => $cpfSemFormatacao,
                    'unidade_id' => $this->unidade_id
                ]
            );

            session()->flash('message', $this->colaborador_id ? 'Colaborador atualizado!' : 'Colaborador criado!');
            $this->closeModal();
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao salvar colaborador: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $colaborador = Colaborador::findOrFail($id);
            $this->colaborador_id = $id;
            $this->nome = $colaborador->nome;
            $this->email = $colaborador->email;

            $this->cpf = $this->formatarCpf($colaborador->cpf);

            $this->unidade_id = $colaborador->unidade_id;
            $this->openModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Colaborador não encontrado');
        }
    }

    public function delete($id)
    {
        try {
            Colaborador::findOrFail($id)->delete();
            session()->flash('message', 'Colaborador excluído!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir colaborador');
        }
    }

    public function update()
    {
        $this->validate([
            'colaborador.nome' => 'required|string|max:255',
        ]);

        $this->colaborador->save();
        session()->flash('message', 'Colaborador atualizado com sucesso.');
    }

    private function formatarCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }
        return $cpf;
    }
}
