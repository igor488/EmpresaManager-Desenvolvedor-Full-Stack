<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'cnpj' => 'required|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/|unique:unidades,cnpj,' . $this->id,
            'bandeira_id' => 'required|exists:bandeiras,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nome_fantasia.required' => 'O nome fantasia é obrigatório.',
            'razao_social.required' => 'A razão social é obrigatória.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.regex' => 'O CNPJ deve estar no formato 00.000.000/0000-00.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'bandeira_id.required' => 'A unidade deve estar vinculada a uma bandeira.',
            'bandeira_id.exists' => 'A bandeira informada não existe.',
        ];
    }
}
