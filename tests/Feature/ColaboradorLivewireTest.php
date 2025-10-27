<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Colaborador;
use App\Models\Unidade;

class ColaboradorLivewireTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function criar_colaborador_livewire()
    {
        $user = User::factory()->create();
        $unidade = Unidade::factory()->create();

        Livewire::actingAs($user)
            ->test('colaboradores')
            ->set('nome', 'João Silva')
            ->set('email', 'joao@empresa.com')
            ->set('cpf', '123.456.789-00')
            ->set('unidade_id', $unidade->id)
            ->call('store')
            ->assertSee('Colaborador criado!');

        $this->assertDatabaseHas('colaboradors', [
            'nome' => 'João Silva',
            'email' => 'joao@empresa.com'
        ]);
    }

    /** @test */
    public function atualizar_colaborador_livewire()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $unidade = Unidade::factory()->create();

        $colaborador = Colaborador::factory()->create([
            'nome' => 'Nome Original',
            'email' => 'original@exemplo.com',
            'cpf' => '111.222.333-44',
            'unidade_id' => $unidade->id
        ]);

        Livewire::actingAs($user)
            ->test('colaboradores')
            ->set('colaborador_id', $colaborador->id)
            ->set('nome', 'Nome Atualizado')
            ->set('email', 'novo@exemplo.com')
            ->set('cpf', '111.222.333-44') 
            ->set('unidade_id', $unidade->id)
            ->call('store')
            ->assertSee('Colaborador atualizado!');

        $this->assertDatabaseHas('colaboradors', [
            'id' => $colaborador->id,
            'nome' => 'Nome Atualizado',
            'email' => 'novo@exemplo.com'
        ]);
    }

    /** @test */
    public function deletar_colaborador_livewire()
    {
        $user = User::factory()->create();
        $colaborador = Colaborador::factory()->create();

        Livewire::actingAs($user)
            ->test('colaboradores')
            ->call('delete', $colaborador->id)
            ->assertSee('Colaborador excluído!');

        $this->assertDatabaseMissing('colaboradors', [
            'id' => $colaborador->id
        ]);
    }
}
