<?php

namespace App\Imports;

use App\Models\ContractPrice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContractPriceImport implements ToModel, WithStartRow, WithValidation
{
    /**
     * @return ContractPrice|null
     */
    public function model(array $row)
    {
        // Assuming the Excel file has columns like:
        // Contract ID | Priceable Type | Priceable ID | Price
        $contractId = $row[0];
        $priceableType = $row[1]; // e.g., 'App\Models\Test'
        $priceableId = $row[2];
        $price = $row[3];

        // Update or create a new contract price
        return ContractPrice::updateOrCreate(
            [
                'contract_id' => $contractId,
                'priceable_type' => $priceableType,
                'priceable_id' => $priceableId,
            ],
            ['price' => $price]
        );
    }

    public function startRow(): int
    {
        return 2; // Assuming the first row is the header
    }

    public function rules(): array
    {
        return [
            '0' => 'required|exists:contracts,id',
            '1' => 'required', // Add validation for priceable type if necessary
            '2' => 'required',
            '3' => 'required|numeric',
        ];
    }
}
