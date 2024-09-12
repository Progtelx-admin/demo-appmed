<?php

namespace App\Imports;

use App\Models\PackagePrice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PackagePriceImport implements ToModel, WithStartRow, WithValidation
{
    /**
     * @return Patient|null
     */
    public function model(array $row)
    {
        if (! empty($row[0])) {
            $package = PackagePrice::where('id', $row[0])->first();

            if (isset($package)) {
                $package->update([
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
            '0' => __('Package id'),
            '1' => __('Package name'),
            '2' => __('Price'),
        ];
    }
}
