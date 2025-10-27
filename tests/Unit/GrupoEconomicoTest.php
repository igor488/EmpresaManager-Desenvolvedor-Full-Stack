<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\GrupoEconomico;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GrupoEconomicoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_grupo_economico()
    {
        $grupo = GrupoEconomico::factory()->create();
        $this->assertDatabaseHas('grupo_economicos', ['id' => $grupo->id]);
    }

    public function test_atualizar_grupo_economico()
    {
        $grupo = GrupoEconomico::factory()->create();
        $grupo->nome = 'Novo Nome';
        $grupo->save();

        $this->assertDatabaseHas('grupo_economicos', ['nome' => 'Novo Nome']);
    }

    public function test_deletar_grupo_economico()
    {
        $grupo = GrupoEconomico::factory()->create();
        $grupo->delete();
        $this->assertDatabaseMissing('grupo_economicos', ['id' => $grupo->id]);
    }

    public function test_relacionamento_bandeiras()
    {
        $grupo = GrupoEconomico::factory()->hasBandeiras(3)->create();
        $this->assertCount(3, $grupo->bandeiras);
    }
}
