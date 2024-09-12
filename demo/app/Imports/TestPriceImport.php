<?php

namespace App\Imports;

use App\Models\TestPrice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TestPriceImport implements ToModel, WithStartRow, WithValidation
{
    /**
     * @return Patient|null
     */
    public function model(array $row)
    {
        if (isset($row[0])) {
            $test = TestPrice::where('id', $row[0])->first();

            if (isset($test)) {
                $test->update([
                    'price' => $row[2],
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '2' => [
                'required',
                'numeric',
            ],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => __('Test id'),
            '1' => __('Name'),
            '2' => __('Price'),
        ];
    }
}
