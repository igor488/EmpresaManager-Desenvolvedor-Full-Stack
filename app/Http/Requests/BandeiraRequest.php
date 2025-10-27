<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BandeiraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'grupo_economico_id' => 'required|exists:grupos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da bandeira é obrigatório.',
            'grupo_economico_id.required' => 'A bandeira deve estar associada a um grupo econômico.',
            'grupo_economico_id.exists' => 'O grupo econômico informado não existe.',
        ];
    }
}
