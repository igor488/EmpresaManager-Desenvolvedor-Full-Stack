<?php

namespace App\Exports;

use App\Models\Colaborador;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ColaboradoresExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $filtros;

    public function __construct($filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function collection()
    {
        $query = Colaborador::query()->with(['unidade.bandeira.grupoEconomico']);

        // Aplicar filtros
        if (!empty($this->filtros['grupo_id'])) {
            $query->whereHas('unidade.bandeira', function ($q) {
                $q->where('grupo_economico_id', $this->filtros['grupo_id']);
            });
        }

        if (!empty($this->filtros['bandeira_id'])) {
            $query->whereHas('unidade', function ($q) {
                $q->where('bandeira_id', $this->filtros['bandeira_id']);
            });
        }

        if (!empty($this->filtros['unidade_id'])) {
            $query->where('unidade_id', $this->filtros['unidade_id']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
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
    }

    public function map($colaborador): array
    {
        $cpfFormatado = $this->formatarCpf($colaborador->cpf);

        return [
            $colaborador->id,
            $colaborador->nome,
            $colaborador->email,
            $cpfFormatado, 
            $colaborador->unidade->nome_fantasia ?? 'N/A',
            $colaborador->unidade->bandeira->nome ?? 'N/A',
            $colaborador->unidade->bandeira->grupoEconomico->nome ?? 'N/A',
            $colaborador->created_at->format('d/m/Y H:i:s'),
            $colaborador->updated_at->format('d/m/Y H:i:s'),
        ];
    }

   
    private function formatarCpf($cpf)
    {
        // Remove qualquer formatação existente
        $cpfNumeros = preg_replace('/[^0-9]/', '', $cpf);
        
        
        if (strlen($cpfNumeros) === 11) {
            return substr($cpfNumeros, 0, 3) . '.' . 
                   substr($cpfNumeros, 3, 3) . '.' . 
                   substr($cpfNumeros, 6, 3) . '-' . 
                   substr($cpfNumeros, 9, 2);
        }
        
    
        if (preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $cpf)) {
            return $cpf;
        }
        
        return $cpfNumeros; 
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT, 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para o cabeçalho
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '3490DC']]
            ],
        ];
    }
}