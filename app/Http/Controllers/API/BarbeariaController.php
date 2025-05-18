<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BarbeariaRequest;
use App\Models\Barbearia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BarbeariaController extends Controller
{
    /**
     * Lista todas as barbearias.
     */
    public function index(Request $request): JsonResponse
    {
        $barbearias = Barbearia::with('servicos')->paginate(15);
        return response()->json($barbearias);
    }

    /**
     * Mostra detalhes de uma barbearia específica.
     */
    public function show(int $id): JsonResponse
    {
        $barbearia = Barbearia::with('servicos')->findOrFail($id);
        return response()->json($barbearia);
    }

    /**
     * Cria uma nova barbearia.
     */
    public function store(BarbeariaRequest $request): JsonResponse
    {
        $data = $request->validated();
        $barbearia = Barbearia::create($data);
        return response()->json($barbearia, 201);
    }

    /**
     * Atualiza uma barbearia existente.
     */
    public function update(int $id, BarbeariaRequest $request): JsonResponse
    {
        $barbearia = Barbearia::findOrFail($id);
        $barbearia->update($request->validated());
        return response()->json($barbearia);
    }

    /**
     * Remove uma barbearia.
     */
    public function destroy(int $id): JsonResponse
    {
        $barbearia = Barbearia::findOrFail($id);
        $barbearia->delete();
        return response()->json(null, 204);
    }

    /**
     * Busca barbearias por nome, localização ou tipo de serviço.
     *
     * Query params:
     *  - q: texto livre (nome ou endereço)
     *  - filters[servico]=id_do_servico
     */
    public function search(Request $request): JsonResponse
    {
        $query   = $request->get('q');
        $filters = $request->get('filters', []);

        $qb = Barbearia::query();

        if ($query) {
            $qb->where('nome', 'like', "%{$query}%")
                ->orWhere('endereco', 'like', "%{$query}%");
        }

       // Filtra pela relação de serviços, usando o id correto
    if (! empty($filters['servico'])) {
        $qb->whereHas('servicos', function ($q) use ($filters) {
            $q->where('servicos.nome', 'like', "%{$filters['servico']}%")
            ->orwhere('servicos.descricao', 'like', "%{$filters['servico']}%");
        });
    }



        $result = $qb->with('servicos')->paginate(15);

        return response()->json($result);
    }
}
