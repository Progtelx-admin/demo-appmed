<?php

namespace App\Imports;

use App\Models\Antibiotic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AntibioticImport implements ToModel, WithHeadingRow, WithStartRow, WithValidation
{
    /**
     * @return Doctor|null
     */
    public function model(array $row)
    {
        Antibiotic::create([
            'name' => $row['name'],
            'shortcut' => $row['name'],
            'commercial_name' => $row['commercial_name'],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
