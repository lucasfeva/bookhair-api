<?php
// app/Http/Requests/AgendamentoRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgendamentoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ou ajuste com policies
    }

    public function rules()
    {
        return [
            // O cliente será sempre o usuário autenticado,
            // então não permitimos passar cliente_id no JSON:
            'barbearia_id'   => ['required','integer', Rule::exists('barbearias','id')],
            'profissional_id'=> ['required','integer', Rule::exists('profissionals','id')],
            'servico_id'     => ['required','integer', Rule::exists('servicos','id')],
            'data_hora'      => 'required|date_format:Y-m-d H:i:s|after:now',
            'status'         => ['nullable','string','in:agendado,concluído,cancelado'],
        ];
    }
}
