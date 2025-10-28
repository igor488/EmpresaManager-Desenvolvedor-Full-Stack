<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Unidade;
use App\Models\Bandeira;
use App\Rules\CnpjValido;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Unidades extends Component
{
    use WithPagination;

    public $nome_fantasia, $razao_social, $cnpj, $bandeira_id, $unidade_id;
    public $isModalOpen = false;

    protected function rules()
    {
        $rules = [
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'bandeira_id' => 'required|exists:bandeiras,id',
        ];

        // Regra condicional para CNPJ
        if ($this->unidade_id) {
            // Em edição: apenas valida formato, sem exigir unicidade
            $rules['cnpj'] = ['required', 'string', new CnpjValido];
        } else {
            // Em criação: deve ser único e válido
            $rules['cnpj'] = ['required', 'string', 'unique:unidades,cnpj', new CnpjValido];
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.unidades', [
            'unidades' => Unidade::with('bandeira')->paginate(10),
            'bandeiras' => Bandeira::all(),
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
        $this->nome_fantasia = '';
        $this->razao_social = '';
        $this->cnpj = '';
        $this->bandeira_id = null;
        $this->unidade_id = null;
        $this->resetErrorBag();
    }

    //Formatar CNPJ para exibição
    private function formatarCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        if (strlen($cnpj) === 14) {
            return substr($cnpj, 0, 2) . '.' .
                   substr($cnpj, 2, 3) . '.' .
                   substr($cnpj, 5, 3) . '/' .
                   substr($cnpj, 8, 4) . '-' .
                   substr($cnpj, 12, 2);
        }
        return $cnpj;
    }

   public function store()
{
    // Remove formatação antes de validar
    $cnpjSemFormatacao = preg_replace('/[^0-9]/', '', $this->cnpj);

    // Validação customizada
    $this->validate([
        'nome_fantasia' => 'required|string|max:255',
        'razao_social' => 'required|string|max:255',
        'bandeira_id' => 'required|exists:bandeiras,id',
        'cnpj' => [
            'required',
            'string',
            function ($attribute, $value, $fail) use ($cnpjSemFormatacao) {
                if (strlen($cnpjSemFormatacao) !== 14) {
                    $fail('O CNPJ deve conter 14 dígitos.');
                    return;
                }

                // Instancia a regra customizada e verifica
                $cnpjRule = new CnpjValido();
                if (!$cnpjRule->passes($attribute, $value)) {
                    $fail($cnpjRule->message());
                }
            },
            $this->unidade_id ? '' : 'unique:unidades,cnpj'
        ],
    ]);

    try {
        Unidade::updateOrCreate(
            ['id' => $this->unidade_id],
            [
                'nome_fantasia' => $this->nome_fantasia,
                'razao_social' => $this->razao_social,
                'cnpj' => $cnpjSemFormatacao,
                'bandeira_id' => $this->bandeira_id
            ]
        );

        session()->flash('message', $this->unidade_id ? 'Unidade atualizada!' : 'Unidade criada!');
        $this->closeModal();
    } catch (\Exception $e) {
        session()->flash('error', 'Erro ao salvar unidade: ' . $e->getMessage());
    }
}

    public function edit($id)
    {
        try {
            $unidade = Unidade::findOrFail($id);
            $this->unidade_id = $id;
            $this->nome_fantasia = $unidade->nome_fantasia;
            $this->razao_social = $unidade->razao_social;


            $this->cnpj = $this->formatarCnpj($unidade->cnpj);

            $this->bandeira_id = $unidade->bandeira_id;
            $this->openModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Unidade não encontrada');
        }
    }

    public function delete($id)
    {
        try {
            Unidade::findOrFail($id)->delete();
            session()->flash('message', 'Unidade excluída!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir unidade');
        }
    }
}
