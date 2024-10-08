<?php

namespace App\Imports;

use App\Models\CulturePrice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CulturePriceImport implements ToModel, WithStartRow, WithValidation
{
    /**
     * @return Patient|null
     */
    public function model(array $row)
    {
        if (! empty($row[0])) {
            $culture = CulturePrice::where('id', $row[0])->first();

            if (isset($culture)) {
                $culture->update([
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
            '2' => 'required|numeric',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => __('Culture id'),
            '1' => __('Culture name'),
            '2' => __('Price'),
        ];
    }
}
