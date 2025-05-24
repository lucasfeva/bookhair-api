<?php

namespace App\Http\Controllers\API;

use App\Models\Servico;
use App\Models\Barbearia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarbeariaRequest;

class BarbeariaController extends Controller
{
    // 1. Lista paginada
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        return response()->json(Barbearia::paginate($perPage));
    }

    // 2. Busca por nome
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q', '');
        $results = Barbearia::where('nome', 'like', "%{$q}%")->get();
        return response()->json($results);
    }

    // 3. Próximas barbearias num raio (km)
    public function nearby(Request $request): JsonResponse
    {
        $lat    = $request->query('lat');
        $lng    = $request->query('lng');
        $radius = $request->query('radius', 10);

        $haversine = "(6371 * acos(
            cos(radians(?)) *
            cos(radians(latitude)) *
            cos(radians(longitude) - radians(?)) +
            sin(radians(?)) *
            sin(radians(latitude))
        ))";

        $barbearias = DB::table('barbearias')
            ->select('*', DB::raw("{$haversine} AS distance"))
            ->setBindings([$lat, $lng, $lat])
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();


        return response()->json($barbearias);
    }

    // 4. Mostrar uma barbearia
    public function show(int $id): JsonResponse
    {
        $bar = Barbearia::findOrFail($id);
        return response()->json($bar);
    }

    // 5. Serviços de uma barbearia
    public function servicos(int $id): JsonResponse
    {
        Barbearia::findOrFail($id);
        $servicos = Servico::where('barbearia_id', $id)->get();

        return response()->json($servicos);
    }

    // 6. Profissionais de uma barbearia
    public function profissionais(int $id): JsonResponse
    {
        $bar = Barbearia::with('profissionais')->findOrFail($id);
        return response()->json($bar->profissionais);
    }

    // 7. Agenda de uma barbearia num dia
    public function agenda(int $id, Request $request): JsonResponse
    {
        $date = $request->query('date'); // formato YYYY-MM-DD
        $bar = Barbearia::findOrFail($id);
        $query = $bar->agendamentos();
        if ($date) {
            $query->whereDate('data_hora', $date);
        }
        return response()->json($query->get());
    }

    // 8. Cria nova barbearia
    public function store(BarbeariaRequest $request): JsonResponse
    {
        $bar = Barbearia::create($request->validated());
        return response()->json($bar, 201);
    }

    // 9. Atualiza barbearia existente
    public function update(int $id, BarbeariaRequest $request): JsonResponse
    {
        $bar = Barbearia::findOrFail($id);
        $bar->update($request->validated());
        return response()->json($bar);
    }


    // 10. Remove barbearia
    public function destroy(int $id): JsonResponse
    {
        $bar = Barbearia::findOrFail($id);
        $bar->delete();
        return response()->json(['message' => 'Barbearia removida']);
    }
}
