<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class DashboardController extends Controller
{
    // 1. Estatísticas mensais: total de agendamentos, faturamento e por status
    public function statsMonthly(Request $request): JsonResponse
    {
        $barbeariaId = $request->query('barbeariaId');
        $month       = $request->query('month');       // ex: '2025-05'
        [$year, $m]  = explode('-', $month);
        $start = "{$year}-{$m}-01 00:00:00";
        $end   = date("Y-m-t 23:59:59", strtotime($start));

        $base = Agendamento::where('agendamentos.barbearia_id', $barbeariaId)
            ->whereBetween('agendamentos.data_hora', [$start, $end]);


        $totalCount = Agendamento::where('agendamentos.barbearia_id', $barbeariaId)
            ->whereBetween('agendamentos.data_hora', [$start, $end])
            ->count();

        $revenue = Agendamento::where('agendamentos.barbearia_id', $barbeariaId)
            ->whereBetween('agendamentos.data_hora', [$start, $end])
            ->join('servicos as s', 'agendamentos.servico_id', '=', 's.id')
            ->sum('s.preco');

        $byStatus = $base
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return response()->json([
            'total_agendamentos' => $totalCount,
            'faturamento'        => $revenue,
            'por_status'         => $byStatus,
        ]);
    }

   
}
