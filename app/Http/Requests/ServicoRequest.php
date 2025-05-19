<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServicoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ou ajuste com policies se necessário
    }

    public function rules()
    {
        $servicoId = $this->route('id'); // para update

        return [
            'barbearia_id'    => [
                'required',
                'integer',
                Rule::exists('barbearias', 'id')
            ],
            'nome'            => 'required|string|max:255',
            'descricao'       => 'nullable|string',
            'duracao_minutos' => 'required|integer|min:1',
            'preco'           => 'required|numeric|min:0',
        ];
    }
}
