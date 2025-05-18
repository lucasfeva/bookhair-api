<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        // Só permite o próprio usuário
        return Auth::check();
    }

    public function rules()
    {
        return [
            'nome'     => 'sometimes|required|string|max:255',
            'email'    => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users','email')->ignore(Auth::id()),
            ],
            'telefone' => 'nullable|string',
            'endereco' => 'nullable|string',
        ];
    }
}
