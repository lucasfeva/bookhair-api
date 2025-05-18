<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServicoRequest;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServicoController extends Controller
{
    // 1. Listagem (com filtro opcional por barbearia_id)
    public function index(Request $request): JsonResponse
    {
        $query = Servico::query();

        if ($request->has('barbearia_id')) {
            $query->where('barbearia_id', $request->query('barbearia_id'));
        }

        return response()->json($query->get());
    }

    // 2. Detalhes de um serviço
    public function show(int $id): JsonResponse
    {
        $servico = Servico::findOrFail($id);
        return response()->json($servico);
    }

    // 3. Criação de serviço
    public function store(ServicoRequest $request): JsonResponse
    {
        $servico = Servico::create($request->validated());
        return response()->json($servico, 201);
    }

    // 4. Atualização de serviço
    public function update(int $id, ServicoRequest $request): JsonResponse
    {
        $servico = Servico::findOrFail($id);
        $servico->update($request->validated());
        return response()->json($servico);
    }

    // 5. Exclusão de serviço
    public function destroy(int $id): JsonResponse
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();

        return response()->json(['message' => 'Serviço removido']);
    }
}
