<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Exports\ColaboradoresExport;
use App\Models\Colaborador;
use App\Models\Unidade;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportExcelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar dados de teste
        $grupo = GrupoEconomico::factory()->create(['nome' => 'Grupo Alpha']);
        $bandeira = Bandeira::factory()->create([
            'nome' => 'Bandeira Beta', 
            'grupo_economico_id' => $grupo->id
        ]);
        $unidade = Unidade::factory()->create([
            'nome_fantasia' => 'Loja Gamma',
            'bandeira_id' => $bandeira->id
        ]);
        
        $this->colaborador = Colaborador::factory()->create([
            'nome' => 'João Silva',
            'email' => 'joao@empresa.com',
            'cpf' => '12345678901',
            'unidade_id' => $unidade->id
        ]);
    }

    /** @test */
    public function export_mapeia_dados_corretamente()
    {
        $export = new ColaboradoresExport();
        $collection = $export->collection();
        
        $this->assertCount(1, $collection);

        $colaborador = $collection->first();
        $exportInstance = new ColaboradoresExport();
        $mapped = $exportInstance->map($colaborador);

        $this->assertEquals($colaborador->id, $mapped[0]);
        $this->assertEquals('João Silva', $mapped[1]);
        $this->assertEquals('joao@empresa.com', $mapped[2]);
        
        $this->assertEquals('123.456.789-01', $mapped[3]);
        
        $this->assertEquals('Loja Gamma', $mapped[4]);
        $this->assertEquals('Bandeira Beta', $mapped[5]);
        $this->assertEquals('Grupo Alpha', $mapped[6]);
    }

    /** @test */
    public function export_retorna_colecao_de_colaboradores()
    {
        $export = new ColaboradoresExport();
        $collection = $export->collection();

        $this->assertCount(1, $collection);
        $this->assertEquals('João Silva', $collection->first()->nome);
    }

    /** @test */
    public function export_aplica_filtro_por_grupo()
    {
        // Criar outro grupo com colaborador
        $outroGrupo = GrupoEconomico::factory()->create(['nome' => 'Grupo Beta']);
        $outraBandeira = Bandeira::factory()->create([
            'nome' => 'Bandeira Gama',
            'grupo_economico_id' => $outroGrupo->id
        ]);
        $outraUnidade = Unidade::factory()->create([
            'nome_fantasia' => 'Loja Delta',
            'bandeira_id' => $outraBandeira->id
        ]);
        
        Colaborador::factory()->create([
            'nome' => 'Maria Souza',
            'email' => 'maria@empresa.com',
            'cpf' => '98765432100',
            'unidade_id' => $outraUnidade->id
        ]);

        $filtros = ['grupo_id' => $outroGrupo->id];
        $export = new ColaboradoresExport($filtros);
        $collection = $export->collection();

        $this->assertCount(1, $collection);
        $this->assertEquals('Maria Souza', $collection->first()->nome);
    }

    /** @test */
    public function export_retorna_headings_corretos()
    {
        $export = new ColaboradoresExport();
        $headings = $export->headings();

        $expectedHeadings = [
            'ID',
            'Nome Completo',
            'Email',
            'CPF',
            'Unidade',
            'Bandeira',
            'Grupo Econômico',
            'Data de Criação',
            'Última Atualização'
        ];

        $this->assertEquals($expectedHeadings, $headings);
    }
}