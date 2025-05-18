<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BarbeariaRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ajuste se quiser usar policies
    }

    public function rules()
    {
        $barbeariaId = $this->route('id'); // para update

        return [
            'nome'      => 'required|string|max:255',
            'endereco'  => 'required|string',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'telefone'  => 'nullable|string|max:20',
            'email'     => [
                'required',
                'email',
                Rule::unique('barbearias','email')
                    ->ignore($barbeariaId, 'id'),
            ],
        ];
    }
}
