<?php

namespace App\Http\Controllers;

use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use App\Models\Unidade;
use App\Models\Colaborador;
use App\Models\Auditoria;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas principais
        $totalGrupos = GrupoEconomico::count();
        $totalBandeiras = Bandeira::count();
        $totalUnidades = Unidade::count();
        $totalColaboradores = Colaborador::count();

        // Atividades recentes (últimas 5) - ajustado para sua estrutura de Auditoria
        $atividadesRecentes = Auditoria::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalGrupos',
            'totalBandeiras',
            'totalUnidades',
            'totalColaboradores',
            'atividadesRecentes'
        ));
    }
}
