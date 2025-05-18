<?php
// app/Http/Controllers/API/AgendamentoController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgendamentoRequest;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    // 1. Lista geral com filtros opcionais
    public function index(Request $request): JsonResponse
    {
        $query = Agendamento::query();

        foreach (['cliente_id','barbearia_id','profissional_id','servico_id','status'] as $field) {
            if ($request->has($field)) {
                $query->where($field, $request->query($field));
            }
        }

        if ($request->has('date')) {
            $query->whereDate('data_hora', $request->query('date'));
        }

        return response()->json($query->get());
    }

    // 2. Detalhes de um agendamento
    public function show(int $id): JsonResponse
    {
        $ag = Agendamento::findOrFail($id);
        return response()->json($ag);
    }

    // 3. Histórico de um usuário
    public function history(int $userId): JsonResponse
    {
        // Garante que só veja o próprio histórico
        if (Auth::id() !== (int) $userId) {
            return response()->json(['message'=>'Não autorizado'], 403);
        }

        $hist = Agendamento::where('cliente_id', $userId)->get();
        return response()->json($hist);
    }

    // 4. Criar agendamento
    public function store(AgendamentoRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['cliente_id'] = Auth::id();
        $data['status']     = 'agendado';

        $ag = Agendamento::create($data);
        return response()->json($ag, 201);
    }

    // 5. Atualizar agendamento
    public function update(int $id, AgendamentoRequest $request): JsonResponse
    {
        $ag = Agendamento::findOrFail($id);
        // Opcional: verificar permissão do usuário
        $ag->update($request->validated());
        return response()->json($ag);
    }

    // 6. Cancelar agendamento (soft change de status)
    public function cancel(int $id): JsonResponse
    {
        $ag = Agendamento::findOrFail($id);

        if ($ag->status === 'cancelado') {
            return response()->json(['message'=>'Já está cancelado'], 400);
        }

        $ag->update(['status'=>'cancelado']);
        return response()->json(['message'=>'Agendamento cancelado']);
    }
}
