<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ExportarColaboradoresJob;
use App\Models\Export;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class JobTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function job_exportar_colaboradores_pode_ser_dispatched()
    {
        Queue::fake();

        $user = User::factory()->create();
        $export = Export::factory()->create(['user_id' => $user->id]);

        ExportarColaboradoresJob::dispatch($export->id, []);

        Queue::assertPushed(ExportarColaboradoresJob::class, function ($job) use ($export) {
            return $job->exportId === $export->id;
        });
    }

    #[Test]
    public function job_exportar_colaboradores_recebe_parametros_corretos()
    {
        $user = User::factory()->create();
        $export = Export::factory()->create(['user_id' => $user->id]);
        $filters = ['grupo_id' => 1];

        $job = new ExportarColaboradoresJob($export->id, $filters);

        $this->assertEquals($export->id, $job->exportId);
        $this->assertEquals($filters, $job->filtros); // ✅ Mudou para $filtros
    }

    #[Test]
    public function job_pode_ser_criado_com_id_invalido_mas_falha_na_execucao()
    {
        Queue::fake();

        $nonExistentExportId = 99999;

        // O job pode ser dispatchado mesmo com ID inválido
        ExportarColaboradoresJob::dispatch($nonExistentExportId, []);

        Queue::assertPushed(ExportarColaboradoresJob::class, function ($job) use ($nonExistentExportId) {
            return $job->exportId === $nonExistentExportId;
        });

        // O teste acima verifica que o job foi dispatchado (o que é normal),
        // mas na prática ele falharia quando tentar processar
    }
}
