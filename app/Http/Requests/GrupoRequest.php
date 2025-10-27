<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do grupo econômico é obrigatório.',
            'nome.string' => 'O nome deve ser um texto válido.',
            'nome.max' => 'O nome pode ter no máximo 255 caracteres.',
        ];
    }
}
