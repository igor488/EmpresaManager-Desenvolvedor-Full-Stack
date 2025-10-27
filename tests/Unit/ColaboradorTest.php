<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Colaborador;
use App\Models\Unidade;

class ColaboradorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function criar_colaborador()
    {
        $unidade = Unidade::factory()->create();

        $colaborador = Colaborador::factory()->create([
            'nome' => 'João Silva',
            'email' => 'joao@email.com',
            'unidade_id' => $unidade->id
        ]);

        // Usar o nome correto da tabela: colaboradors
        $this->assertDatabaseHas('colaboradors', [
            'nome' => 'João Silva',
            'email' => 'joao@email.com',
            'unidade_id' => $unidade->id
        ]);
    }

    /** @test */
    public function atualizar_colaborador()
    {
        $colaborador = Colaborador::factory()->create();

        $colaborador->update([
            'nome' => 'Maria Santos',
            'email' => 'maria@email.com'
        ]);

        $this->assertDatabaseHas('colaboradors', [
            'nome' => 'Maria Santos',
            'email' => 'maria@email.com'
        ]);
    }

    /** @test */
    public function deletar_colaborador()
    {
        $colaborador = Colaborador::factory()->create();

        $colaboradorId = $colaborador->id;
        $colaborador->delete();

        $this->assertDatabaseMissing('colaboradors', [
            'id' => $colaboradorId
        ]);
    }

    /** @test */
    public function relacionamento_unidade()
    {
        $unidade = Unidade::factory()->create();
        $colaborador = Colaborador::factory()->create([
            'unidade_id' => $unidade->id
        ]);

        $this->assertEquals($unidade->id, $colaborador->unidade->id);
        $this->assertEquals($unidade->nome, $colaborador->unidade->nome);
    }
}
