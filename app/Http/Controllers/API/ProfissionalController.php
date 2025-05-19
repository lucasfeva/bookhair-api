<?php
// app/Http/Controllers/API/ProfissionalController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfissionalRequest;
use App\Models\Profissional;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProfissionalController extends Controller
{
    // 1. Listagem (opcional filter por barbearia_id)
    public function index(Request $request): JsonResponse
    {
        $query = Profissional::query();
        if ($request->has('barbearia_id')) {
            $query->where('barbearia_id', $request->query('barbearia_id'));
        }
        return response()->json($query->get());
    }

    // 2. Detalhes de um profissional
    public function show(int $id): JsonResponse
    {
        $prof = Profissional::findOrFail($id);
        return response()->json($prof);
    }

    // 3. Horários (lista de agendamentos) num dia específico
    public function horarios(int $id, Request $request): JsonResponse
    {
        $date = $request->query('date'); // YYYY-MM-DD
        $prof = Profissional::findOrFail($id);
        $query = $prof->agendamentos();
        if ($date) {
            $query->whereDate('data_hora', $date);
        }
        return response()->json($query->get());
    }

    // 4. Serviços atribuídos ao profissional
    public function servicos(int $id): JsonResponse
    {
        $prof = Profissional::with('servicos')->findOrFail($id);
        return response()->json($prof->servicos);
    }

    // 5. Criar profissional
    public function store(ProfissionalRequest $request): JsonResponse
    {
        $prof = Profissional::create($request->validated());
        return response()->json($prof, 201);
    }

    // 6. Atualizar profissional
    public function update(int $id, ProfissionalRequest $request): JsonResponse
    {
        $prof = Profissional::findOrFail($id);
        $prof->update($request->validated());
        return response()->json($prof);
    }

    // 7. Remover profissional
    public function destroy(int $id): JsonResponse
    {
        $prof = Profissional::findOrFail($id);
        $prof->delete();
        return response()->json(['message' => 'Profissional removido']);
    }

    // 8. Atribuir serviço (many-to-many)
    public function assignService(int $id, int $serviceId): JsonResponse
    {
        $prof = Profissional::findOrFail($id);
        // opcional: validar se o serviço existe
        Servico::findOrFail($serviceId);

        $prof->servicos()->syncWithoutDetaching([$serviceId]);

        return response()->json(['message' => "Serviço {$serviceId} atribuído"]);
    }

    // 9. Remover serviço
    public function removeService(int $id, int $serviceId): JsonResponse
    {
        $prof = Profissional::findOrFail($id);
        $prof->servicos()->detach($serviceId);

        return response()->json(['message' => "Serviço {$serviceId} removido"]);
    }
}
