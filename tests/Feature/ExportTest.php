<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ExportarColaboradoresJob;
use App\Models\User;
use App\Models\Export;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dispatch_job_exportacao()
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $export = Export::factory()->create([
            'user_id' => $user->id,
            'file_name' => 'test_export.xlsx',
            'status' => 'completed'
        ]);

        $filtros = ['grupo_id' => 1];

        ExportarColaboradoresJob::dispatch($export->id, $filtros);

        Queue::assertPushed(ExportarColaboradoresJob::class, function ($job) use ($export, $filtros) {
            return $job->exportId === $export->id && $job->filtros === $filtros;
        });
    }

    /** @test */
    public function job_export_gera_arquivo()
    {
        $user = User::factory()->create();

        // Criar export com status válido
        $export = Export::factory()->create([
            'user_id' => $user->id,
            'file_name' => 'colaboradores_export.xlsx',
            'status' => 'completed' 
        ]);

        $filtros = ['grupo_id' => 1];

        
        $job = new ExportarColaboradoresJob($export->id, $filtros);

        // Verificar se o job foi criado corretamente
        $this->assertEquals($export->id, $job->exportId);
        $this->assertEquals($filtros, $job->filtros);

        // Verificar estado do export
        $this->assertEquals('completed', $export->fresh()->status);
    }
}
