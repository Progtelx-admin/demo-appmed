<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ResultsExport implements FromCollection, WithEvents, WithHeadings
{
    public function collection()
    {

        return DB::table('patients')
            ->whereDate('groups.updated_at', '=', Carbon::today())
            ->join('groups', 'groups.patient_id', '=', 'patients.id')
            ->join('group_tests', 'groups.id', '=', 'group_tests.group_id')
            ->join('tests', 'group_tests.test_id', '=', 'tests.id')
            ->join('group_test_results', 'group_tests.id', '=', 'group_test_results.group_test_id')
            ->join('branches', 'groups.branch_id', '=', 'branches.id')
            ->select('patients.code', 'groups.barcode', 'patients.name as patients.name ', 'patients.gender', 'patients.dob', 'patients.phone', 'tests.name as tests.name', 'group_test_results.result', 'group_test_results.status', 'branches.name', 'groups.updated_at')
            ->get();

    }

    public function headings(): array
    {
        return [
            'Patients code',
            'Barcode',
            'Patient Name',
            'Gender',
            'DOB',
            'Phone',
            'Test Name',
            'Result',
            'Status',
            'Branche',
            'Updated',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:K1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('00FF00');

            },
        ];
        $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $event->sheet->styleCells(
            'A1:K1',
            [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['argb' => '0000000'],
                    ],
                ],
            ]
        );

    }
}
