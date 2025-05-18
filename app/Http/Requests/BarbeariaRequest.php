<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarbeariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ou verifique permissão via policies
    }

    public function rules(): array
    {
        return [
            'nome'        => 'required|string|max:100',
            'endereco'    => 'required|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'telefone'    => 'nullable|string|max:20',
            'email'       => 'nullable|email'
            // adicione outros campos conforme modelo
        ];
    }
}
