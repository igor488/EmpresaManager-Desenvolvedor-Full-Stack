<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use App\Models\Unidade;
use App\Models\Colaborador;
use App\Models\Export;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RelacionamentosTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function grupo_tem_muitas_bandeiras()
    {
        $grupo = GrupoEconomico::factory()->create();
        $bandeira1 = Bandeira::factory()->for($grupo)->create();
        $bandeira2 = Bandeira::factory()->for($grupo)->create();

        $this->assertCount(2, $grupo->bandeiras);
        $this->assertTrue($grupo->bandeiras->contains($bandeira1));
        $this->assertTrue($grupo->bandeiras->contains($bandeira2));
    }

    #[Test]
    public function bandeira_tem_muitas_unidades()
    {
        $bandeira = Bandeira::factory()->create();
        $unidade1 = Unidade::factory()->for($bandeira)->create();
        $unidade2 = Unidade::factory()->for($bandeira)->create();

        $this->assertCount(2, $bandeira->unidades);
        $this->assertTrue($bandeira->unidades->contains($unidade1));
        $this->assertTrue($bandeira->unidades->contains($unidade2));
    }

    #[Test]
    public function unidade_tem_muitos_colaboradores()
    {
        $unidade = Unidade::factory()->create();
        $colaborador1 = Colaborador::factory()->for($unidade)->create();
        $colaborador2 = Colaborador::factory()->for($unidade)->create();

        $this->assertCount(2, $unidade->colaboradores);
        $this->assertTrue($unidade->colaboradores->contains($colaborador1));
        $this->assertTrue($unidade->colaboradores->contains($colaborador2));
    }

    #[Test]
    public function user_tem_muitos_exports()
    {
        $user = User::factory()->create();
        $export1 = Export::factory()->for($user)->create();
        $export2 = Export::factory()->for($user)->create();

        $this->assertCount(2, $user->exports);
        $this->assertTrue($user->exports->contains($export1));
        $this->assertTrue($user->exports->contains($export2));
    }

    #[Test]
    public function export_pertence_a_user()
    {
        $user = User::factory()->create();
        $export = Export::factory()->for($user)->create();

        $this->assertEquals($user->id, $export->user->id);
        $this->assertInstanceOf(User::class, $export->user);
    }

    #[Test]
    public function colaborador_pertence_a_unidade_que_pertence_a_bandeira_que_pertence_a_grupo()
    {
        $grupo = GrupoEconomico::factory()->create();
        $bandeira = Bandeira::factory()->for($grupo)->create();
        $unidade = Unidade::factory()->for($bandeira)->create();
        $colaborador = Colaborador::factory()->for($unidade)->create();

        $this->assertEquals($unidade->id, $colaborador->unidade_id);
        $this->assertEquals($bandeira->id, $colaborador->unidade->bandeira_id);
        $this->assertEquals($grupo->id, $colaborador->unidade->bandeira->grupo_economico_id);
    }
}
