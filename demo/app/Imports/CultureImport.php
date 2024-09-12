<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Culture;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CultureImport implements ToModel, WithHeadingRow, WithStartRow, WithValidation
{
    /**
     * @return Culture|null
     */
    public function model(array $row)
    {
        if (isset($row['category']) && ! empty($row['category'])) {
            $category = Category::where('name', $row['category'])->first();
            if (! isset($category)) {
                $category = Category::create([
                    'name' => $row['category'],
                ]);
            }
        }

        if (isset($row['id'])) {
            $culture = Culture::find($row['id']);
            if (isset($culture)) {
                $culture->update([
                    'category_id' => (isset($category)) ? $category['id'] : '',
                    'name' => $row['name'],
                    'sample_type' => $row['sample_type'],
                    'precautions' => $row['precautions'],
                    'price' => $row['price'],
                    'pantheon_id' => $row['pantheon_id'],
                ]);
            } else {
                Culture::create([
                    'category_id' => (isset($category)) ? $category['id'] : '',
                    'name' => $row['name'],
                    'sample_type' => $row['sample_type'],
                    'precautions' => $row['precautions'],
                    'price' => $row['price'],
                    'pantheon_id' => $row['pantheon_id'],
                ]);
            }
        } else {
            Culture::create([
                'category_id' => (isset($category)) ? $category['id'] : '',
                'name' => $row['name'],
                'sample_type' => $row['sample_type'],
                'precautions' => $row['precautions'],
                'price' => $row['price'],
                'pantheon_id' => $row['pantheon_id'],
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public $id = '';

    public function rules(): array
    {
        return [
            'category' => 'required',
            'name' => 'required',
            'price' => 'required',
        ];
    }
}
