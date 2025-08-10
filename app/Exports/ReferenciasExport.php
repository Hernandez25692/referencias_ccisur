<?php

namespace App\Exports;

use App\Models\Referencia;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReferenciasExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct(
        protected ?string $departamento = null,
        protected ?string $desde = null,
        protected ?string $hasta = null,
    ) {}

    public function query()
    {
        return Referencia::query()
            ->when($this->departamento, fn($q) => $q->where('departamento', $this->departamento))
            ->when($this->desde && $this->hasta, function ($q) {
                $q->whereBetween('created_at', [
                    $this->desde . ' 00:00:00',
                    $this->hasta . ' 23:59:59',
                ]);
            })
            ->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return [
            '#',
            'Correlativo',
            'Asunto',
            'Solicitado por',
            'Autorizado por',
            'Departamento',
            'Estado',
            'Fecha de Generación',
            'Última Modificación',
        ];
    }

    public function map($ref): array
    {
        return [
            $ref->id,
            $ref->correlativo,
            $ref->asunto,
            $ref->solicitado_por,
            $ref->autorizado_por,
            $ref->departamento,
            ucfirst($ref->estado),
            optional($ref->created_at)->format('Y-m-d H:i:s'),
            optional($ref->updated_at)->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Negrita y fondo en encabezados
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '002C5F'], // Azul institucional
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Bordes tipo tabla
        $sheet->getStyle('A1:I' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        return [];
    }
}
