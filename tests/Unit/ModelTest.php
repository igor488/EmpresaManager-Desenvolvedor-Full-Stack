<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use App\Models\Unidade;
use App\Models\Colaborador;
use App\Models\Export;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_pode_ser_criado()
    {
        $user = User::factory()->create([
            'name' => 'João Silva',
            'email' => 'joao@empresa.com'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'João Silva',
            'email' => 'joao@empresa.com'
        ]);
    }

    #[Test]
    public function grupo_economico_pode_ser_criado()
    {
        $grupo = GrupoEconomico::create([
            'nome' => 'Grupo Alpha',
        ]);

        $this->assertDatabaseHas('grupo_economicos', [
            'nome' => 'Grupo Alpha',
        ]);
    }

    #[Test]
    public function bandeira_pode_ser_criada_com_grupo()
    {
        $grupo = GrupoEconomico::factory()->create();
        $bandeira = Bandeira::create([
            'nome' => 'Bandeira A',
            'grupo_economico_id' => $grupo->id
        ]);

        $this->assertDatabaseHas('bandeiras', [
            'nome' => 'Bandeira A',
            'grupo_economico_id' => $grupo->id
        ]);
    }

    #[Test]
    public function unidade_pode_ser_criada_com_bandeira()
    {
        $bandeira = Bandeira::factory()->create();
        $unidade = Unidade::create([
            'nome_fantasia' => 'Loja Centro',
            'razao_social' => 'Loja Centro LTDA',
            'cnpj' => '12345678000195',
            'bandeira_id' => $bandeira->id
        ]);

        $this->assertDatabaseHas('unidades', [
            'nome_fantasia' => 'Loja Centro',
            'cnpj' => '12345678000195'
        ]);
    }

    #[Test]
    public function colaborador_pode_ser_criado_com_unidade()
    {
        $unidade = Unidade::factory()->create();
        $colaborador = Colaborador::create([
            'nome' => 'Maria Santos',
            'email' => 'maria@empresa.com',
            'cpf' => '12345678901',
            'unidade_id' => $unidade->id
        ]);

        $this->assertDatabaseHas('colaboradors', [
            'nome' => 'Maria Santos',
            'email' => 'maria@empresa.com'
        ]);
    }

    #[Test]
    public function export_pode_ser_criado_com_user()
    {
        $user = User::factory()->create();
        $export = Export::create([
            'user_id' => $user->id,
            'file_name' => 'relatorio.xlsx',
            'status' => 'completed',
            'filters' => ['grupo_id' => 1]
        ]);

        $this->assertDatabaseHas('exports', [
            'file_name' => 'relatorio.xlsx',
            'status' => 'completed'
        ]);
    }
}
