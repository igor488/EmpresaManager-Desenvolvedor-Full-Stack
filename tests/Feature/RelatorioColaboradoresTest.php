<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use App\Models\Unidade;
use App\Models\Colaborador;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RelatorioColaboradoresTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pagina_relatorio_carregada_com_sucesso()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->get('/relatorio-colaboradores');

        $response->assertStatus(200);
        $response->assertSee('Relatório de Colaboradores');
        $response->assertSee('Exporte dados de colaboradores com filtros avançados');
    }

    #[Test]
    public function lista_grupos_economicos_no_filtro()
    {
        $user = User::factory()->create();
        $grupo = GrupoEconomico::factory()->create(['nome' => 'Grupo Teste']);

        $response = $this->actingAs($user)
                        ->get('/relatorio-colaboradores');

        $response->assertSee('Grupo Teste');
    }

    #[Test]
    public function filtro_bandeiras_atualiza_ao_selecionar_grupo()
    {
        $user = User::factory()->create();
        $grupo1 = GrupoEconomico::factory()->create();
        $grupo2 = GrupoEconomico::factory()->create();

        $bandeira1 = Bandeira::factory()->for($grupo1)->create(['nome' => 'Bandeira A']);
        $bandeira2 = Bandeira::factory()->for($grupo2)->create(['nome' => 'Bandeira B']);

        Livewire::actingAs($user)
                ->test('relatorio-colaboradores')
                ->set('grupo_id', $grupo1->id)
                ->assertSet('grupo_id', $grupo1->id)
                ->assertSee('Bandeira A')
                ->assertDontSee('Bandeira B');
    }

    #[Test]
    public function filtro_unidades_atualiza_ao_selecionar_bandeira()
    {
        $user = User::factory()->create();
        $bandeira1 = Bandeira::factory()->create();
        $bandeira2 = Bandeira::factory()->create();

        $unidade1 = Unidade::factory()->for($bandeira1)->create(['nome_fantasia' => 'Loja A']);
        $unidade2 = Unidade::factory()->for($bandeira2)->create(['nome_fantasia' => 'Loja B']);

        Livewire::actingAs($user)
                ->test('relatorio-colaboradores')
                ->set('bandeira_id', $bandeira1->id)
                ->assertSet('bandeira_id', $bandeira1->id)
                ->assertSee('Loja A')
                ->assertDontSee('Loja B');
    }

    #[Test]
    public function estatisticas_sao_calculadas_corretamente()
    {
        $user = User::factory()->create();
        $unidade = Unidade::factory()->create();

        Colaborador::factory()->count(3)->for($unidade)->create();

        Livewire::actingAs($user)
                ->test('relatorio-colaboradores')
                ->assertSet('estatisticas.total', 3)
                ->assertSet('estatisticas.com_filtro', false);
    }

    #[Test]
    public function estatisticas_com_filtro_aplicado()
    {
        $user = User::factory()->create();
        $grupo = GrupoEconomico::factory()->create();
        $bandeira = Bandeira::factory()->for($grupo)->create();
        $unidade = Unidade::factory()->for($bandeira)->create();

        Colaborador::factory()->count(2)->for($unidade)->create();
        // Colaborador de outro grupo
        Colaborador::factory()->count(1)->create();

        Livewire::actingAs($user)
                ->test('relatorio-colaboradores')
                ->set('grupo_id', $grupo->id)
                ->assertSet('estatisticas.total', 2)
                ->assertSet('estatisticas.com_filtro', true);
    }
}
