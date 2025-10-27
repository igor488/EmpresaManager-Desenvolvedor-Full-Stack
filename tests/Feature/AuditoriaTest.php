<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Colaborador;

class AuditoriaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function auditoria_criacao_colaborador()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $colaborador = Colaborador::factory()->create();

      
        $this->assertDatabaseHas('auditorias', [
            'user_id' => $user->id,
            'entidade' => Colaborador::class,
            'entidade_id' => $colaborador->id,
            'acao' => 'created'
        ]);
    }

    /** @test */
    public function auditoria_atualizacao_colaborador()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $colaborador = Colaborador::factory()->create(['nome' => 'Nome Antigo']);

        $colaborador->update(['nome' => 'Novo Nome']);

       
        $this->assertDatabaseHas('auditorias', [
            'user_id' => $user->id,
            'entidade' => Colaborador::class, 
            'entidade_id' => $colaborador->id, 
            'acao' => 'updated' 
        ]);
    }

    /** @test */
    public function auditoria_delecao_colaborador()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $colaborador = Colaborador::factory()->create();

        $colaborador->delete();

       
        $this->assertDatabaseHas('auditorias', [
            'user_id' => $user->id,
            'entidade' => Colaborador::class,
            'entidade_id' => $colaborador->id, 
            'acao' => 'deleted'
        ]);
    }
}
