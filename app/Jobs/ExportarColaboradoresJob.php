<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ColaboradoresExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExportarColaboradoresJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $exportId;
    public $filtros;

    public function __construct($exportId, $filtros = [])
    {
        $this->exportId = $exportId;
        $this->filtros = $filtros;
    }

    public function handle()
    {
        Log::info("🔄 Iniciando export job ID: " . $this->exportId);

        $export = Export::find($this->exportId);

        if (!$export) {
            Log::error("❌ Export não encontrado: " . $this->exportId);
            $this->fail(new \Exception("Export não encontrado: " . $this->exportId));
            return;
        }

        try {
            $export->update(['status' => 'processing']);

            $exportInstance = new ColaboradoresExport($this->filtros);

            $fileName = $export->file_name ?? 'colaboradores_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            $filePath = 'exports/' . $fileName;

            Excel::store($exportInstance, $filePath, 'public');

           
            $export->update([
                'status' => 'completed',
                'file_path' => $filePath,
                'file_name' => $fileName,
                'disk' => 'public',
                'progress' => 100
            ]);

            Log::info("✅ Arquivo salvo em: storage/app/public/" . $filePath);
            Log::info("🌐 URL acessível: " . Storage::disk('public')->url($filePath));

        } catch (\Exception $e) {
            Log::error("❌ Erro no export: " . $e->getMessage());

            $export->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'progress' => 0
            ]);

            $this->fail($e);
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("💥 Job falhou: " . $exception->getMessage());

        $export = Export::find($this->exportId);
        if ($export) {
            $export->update([
                'status' => 'failed',
                'error_message' => 'Job falhou: ' . $exception->getMessage(),
                'progress' => 0
            ]);
        }
    }
}
