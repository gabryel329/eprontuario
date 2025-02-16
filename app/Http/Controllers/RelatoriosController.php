<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Convenio;
use App\Models\Pacientes;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatoriosController extends Controller
{
    public function index(Request $request)
    {
        $agendas = Agenda::all();
        $convenios = Convenio::all();
        $profissionals = Profissional::all();

        // Criar intervalo dos últimos 12 meses
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Criar estrutura de meses com valores zerados
        $months = [];
        $current = clone $startDate;
        while ($current <= $endDate) {
            $months[$current->format('Y-m')] = 0;
            $current->addMonth();
        }

        // Buscar dados reais do banco
        $chartData = Agenda::query()
            ->whereBetween('data', [$startDate, $endDate])
            ->selectRaw("TO_CHAR(data, 'YYYY-MM') as mes, COUNT(*) as total_agendamentos")
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->pluck('total_agendamentos', 'mes')
            ->toArray();

        // Mesclar com estrutura fixa para garantir todos os meses
        foreach ($chartData as $mes => $total) {
            $months[$mes] = $total;
        }

        // Ordenar corretamente
        ksort($months);

        // Estatísticas rápidas para os cards
        $totalAgendamentos = array_sum($months);
        $totalCancelados = Agenda::where('status', 'CANCELADO')->count();
        $totalChegaram = Agenda::where('status', 'CHEGOU')->count();
        $totalPendentes = Agenda::where('status', 'PENDENTE')->count();
        $totalUsuarios = Profissional::count();
        $totalMedicos = Profissional::all()->whereNull('conselho_1')->count(); // Assumindo que há um campo "tipo" e "conselho_1"
        $totalProfissionaisComConselho = Profissional::whereNotNull('conselho_1')->count();
        $totalPacientes = Pacientes::count();

        // Formatar dados para os gráficos
        $formattedData = [
            'labels' => array_map(fn($mes) => Carbon::createFromFormat('Y-m', $mes)->format('m/Y'), array_keys($months)),
            'agendamentos' => array_values($months),
            'status' => [
                'labels' => ['CANCELADO', 'CHEGOU'],
                'values' => [$totalCancelados, $totalChegaram],
                'colors' => ['#FFCE56', '#AAAAAA']
            ],
            'stats' => [
                'totalAgendamentos' => $totalAgendamentos,
                'totalCancelados' => $totalCancelados,
                'totalChegaram' => $totalChegaram,
                'totalPendentes' => $totalPendentes,
                'totalUsuarios' => $totalUsuarios,
                'totalMedicos' => $totalMedicos,
                'totalPacientes' => $totalPacientes,
            ]
        ];

        return view('financeiro.relatorio_bi', compact('agendas', 'profissionals', 'convenios', 'formattedData'));
    }
}
