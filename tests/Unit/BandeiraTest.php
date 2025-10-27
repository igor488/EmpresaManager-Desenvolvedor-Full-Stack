<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BandeiraTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_bandeira()
    {
        $bandeira = Bandeira::factory()->create();
        $this->assertDatabaseHas('bandeiras', ['id' => $bandeira->id]);
    }

    public function test_atualizar_bandeira()
    {
        $bandeira = Bandeira::factory()->create();
        $bandeira->nome = 'Nova Bandeira';
        $bandeira->save();
        $this->assertDatabaseHas('bandeiras', ['nome' => 'Nova Bandeira']);
    }

    public function test_deletar_bandeira()
    {
        $bandeira = Bandeira::factory()->create();
        $bandeira->delete();
        $this->assertDatabaseMissing('bandeiras', ['id' => $bandeira->id]);
    }

    public function test_relacionamento_grupo()
    {
        $grupo = GrupoEconomico::factory()->create();
        $bandeira = Bandeira::factory()->create(['grupo_economico_id' => $grupo->id]);
        $this->assertEquals($bandeira->grupoEconomico->id, $grupo->id);
    }
}
