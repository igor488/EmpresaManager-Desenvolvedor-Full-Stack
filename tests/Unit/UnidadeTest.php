<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Unidade;
use App\Models\Bandeira;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnidadeTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_unidade()
    {
        $unidade = Unidade::factory()->create();
        $this->assertDatabaseHas('unidades', ['id' => $unidade->id]);
    }

    public function test_atualizar_unidade()
    {
        $unidade = Unidade::factory()->create();
        $unidade->nome_fantasia = 'Nova Unidade';
        $unidade->save();
        $this->assertDatabaseHas('unidades', ['nome_fantasia' => 'Nova Unidade']);
    }

    public function test_deletar_unidade()
    {
        $unidade = Unidade::factory()->create();
        $unidade->delete();
        $this->assertDatabaseMissing('unidades', ['id' => $unidade->id]);
    }

    public function test_relacionamento_bandeira()
    {
        $bandeira = Bandeira::factory()->create();
        $unidade = Unidade::factory()->create(['bandeira_id' => $bandeira->id]);
        $this->assertEquals($unidade->bandeira->id, $bandeira->id);
    }
}
