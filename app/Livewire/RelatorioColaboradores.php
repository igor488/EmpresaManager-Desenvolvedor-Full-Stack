<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use App\Models\Unidade;
use App\Models\Export;
use App\Models\Colaborador;
use App\Jobs\ExportarColaboradoresJob;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ColaboradoresExport;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Layout('components.layouts.app')]
class RelatorioColaboradores extends Component
{
    public $grupo_id = '';
    public $bandeira_id = '';
    public $unidade_id = '';
    public $bandeirasFiltradas = [];
    public $unidadesFiltradas = [];
    public $exportando = false;
    public $currentExportId = null;
    public $polling = false;

    public function mount()
    {
        $this->atualizarListas();
    }

    public function updatedGrupoId()
    {
        $this->bandeira_id = '';
        $this->unidade_id = '';
        $this->atualizarListas();
    }

    public function updatedBandeiraId()
    {
        $this->unidade_id = '';
        $this->carregarUnidades();
    }

    protected function atualizarListas()
    {
        $this->carregarBandeiras();
        $this->carregarUnidades();
    }

    protected function carregarBandeiras()
    {
        $this->bandeirasFiltradas = $this->grupo_id
            ? Bandeira::where('grupo_economico_id', $this->grupo_id)->get()
            : Bandeira::all();
    }

    protected function carregarUnidades()
    {
        if ($this->bandeira_id) {
            $this->unidadesFiltradas = Unidade::where('bandeira_id', $this->bandeira_id)->get();
        } elseif ($this->grupo_id) {
            $this->unidadesFiltradas = Unidade::whereHas('bandeira', fn($q) =>
                $q->where('grupo_economico_id', $this->grupo_id)
            )->get();
        } else {
            $this->unidadesFiltradas = Unidade::all();
        }
    }

    public function exportExcel()
    {
        // Gerar filename único
        $filename = 'colaboradores_' . now()->format('Y-m-d_H-i-s') . '_' . Str::random(6) . '.xlsx';

        $filtros = [
            'grupo_id' => $this->grupo_id ?: null,
            'bandeira_id' => $this->bandeira_id ?: null,
            'unidade_id' => $this->unidade_id ?: null,
        ];

        // Cria registro na tabela exports
        $export = Export::create([
            'user_id' => auth()->id(),
            'file_name' => $filename,
            'disk' => 'public',
            'status' => 'queued',
            'filters' => $filtros,
        ]);

        // Dispatch do job
        ExportarColaboradoresJob::dispatch($export->id, $filtros);

        // Configurar UI: start polling por esse export
        $this->currentExportId = $export->id;
        $this->polling = true;
        $this->exportando = true;

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => 'Exportação iniciada! Você será notificado quando estiver pronta.',
        ]);
    }

    public function checkExportStatus()
    {
        if (!$this->currentExportId) {
            $this->polling = false;
            return;
        }

        $export = Export::find($this->currentExportId);

        if (!$export) {
            $this->polling = false;
            $this->exportando = false;
            return;
        }

        switch ($export->status) {
            case 'completed':
                $this->dispatch('toast', [
                    'type' => 'success',
                    'message' => 'Exportação concluída! Faça o download do arquivo.',
                ]);
                $this->polling = false;
                $this->exportando = false;
                break;

            case 'failed':
                $this->dispatch('toast', [
                    'type' => 'error',
                    'message' => 'Falha na exportação: ' . ($export->error_message ?? 'Erro desconhecido'),
                ]);
                $this->polling = false;
                $this->exportando = false;
                break;
        }
    }

    public function getCurrentExportProperty()
    {
        if (!$this->currentExportId) {
            return null;
        }
        return Export::find($this->currentExportId);
    }

    // ✅ MÉTODO ÚNICO DE DOWNLOAD CORRIGIDO
public function downloadExport()
{
    if (!$this->currentExportId) {
        $this->dispatch('toast', [
            'type' => 'error',
            'message' => 'Nenhum export selecionado.',
        ]);
        return;
    }

    $export = Export::find($this->currentExportId);

    if (!$export) {
        $this->dispatch('toast', [
            'type' => 'error',
            'message' => 'Export não encontrado.',
        ]);
        return;
    }

    if ($export->status !== 'completed') {
        $this->dispatch('toast', [
            'type' => 'error',
            'message' => 'Export ainda não está pronto para download.',
        ]);
        return;
    }

    if (!Storage::disk('public')->exists($export->file_path)) {
        $this->dispatch('toast', [
            'type' => 'error',
            'message' => 'Arquivo não encontrado no storage.',
        ]);
        return;
    }


    $fileUrl = asset('storage/' . $export->file_path);

    return redirect()->away($fileUrl);
}

public function getDownloadUrlProperty()
{
    if (!$this->currentExportId) {
        return null;
    }

    $export = Export::find($this->currentExportId);

    if (!$export || $export->status !== 'completed' || !$export->file_path) {
        return null;
    }

    return asset('storage/' . $export->file_path);
}

    public function getEstatisticasProperty()
    {
        $query = Colaborador::query();

        if ($this->grupo_id) {
            $query->whereHas('unidade.bandeira', fn($q) =>
                $q->where('grupo_economico_id', $this->grupo_id)
            );
        }

        if ($this->bandeira_id) {
            $query->whereHas('unidade', fn($q) =>
                $q->where('bandeira_id', $this->bandeira_id)
            );
        }

        if ($this->unidade_id) {
            $query->where('unidade_id', $this->unidade_id);
        }

        return [
            'total' => $query->count(),
            'com_filtro' => (bool) ($this->grupo_id || $this->bandeira_id || $this->unidade_id),
        ];
    }

    public function render()
    {
        return view('livewire.relatorio-colaboradores', [
            'grupos' => GrupoEconomico::orderBy('nome')->get(),
            'estatisticas' => $this->estatisticas,
        ]);


    }

}
