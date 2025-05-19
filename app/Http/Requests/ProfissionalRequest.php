<?php
// app/Http/Requests/ProfissionalRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfissionalRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ajuste com policies se necessário
    }

    public function rules()
    {
        $profissionalId = $this->route('id');

        return [
            'barbearia_id' => [
                'required',
                'integer',
                Rule::exists('barbearias', 'id')
            ],
            'nome'         => 'required|string|max:255',
        ];
    }
}
