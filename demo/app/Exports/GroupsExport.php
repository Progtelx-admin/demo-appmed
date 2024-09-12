<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GroupsExport implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

    private $query;

    private $from;

    private $to;

    public function __construct($query, $from, $to)
    {
        $this->query = $query;
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        // Apply the date filter and get the data
        $data = $this->query->whereBetween('groups.created_at', [$this->from, $this->to])->get();

        $rowNumber = 1;

        return $data->map(function ($group) use (&$rowNumber) {
            return [
                'NO' => $rowNumber++,
                'ID' => $group->id,
                'Created At' => $group->created_at,
                'Patient Name' => $group->patient->name ?? '', // Using optional object in case relation is null
                'Patient DOB' => $group->patient->dob ?? '',
                'Patient Phone' => $group->patient->phone ?? '',
                'Merged Items' => implode(', ', $group->mergedItems->toArray()),
                'Subtotal' => $group->subtotal,
                'Discount' => $group->discount !== null ? number_format($group->discount, 2, '.', '') : '0.00',
                'Total' => $group->total,
                'Comment' => $group->comment,
                'Reference' => $group->reference,
                'Contract' => $group->contract->title ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NO',
            'ID',
            'Created At',
            'Patient Name',
            'Patient DOB',
            'Patient Phone',
            'Merged Items',
            'Subtotal',
            'Discount',
            'Total',
            'Comment',
            'Reference',
            'Contract',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A:M')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A1:M1')->getFont()->setSize(12);

        return [];
    }
}
