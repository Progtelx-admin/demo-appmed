<?php

use App\Models\Branch;
use App\Models\Culture;
use App\Models\CulturePrice;
use Illuminate\Database\Seeder;

class CulturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Culture::truncate();
        CulturePrice::truncate();

        $culturesData = [
            ['name' => 'Blood Culture', 'price' => 100],
            ['name' => 'Urine Culture', 'price' => 80],
            ['name' => 'Throat Culture', 'price' => 90],
            ['name' => 'Stool Culture', 'price' => 85],
            ['name' => 'Skin Culture', 'price' => 95],
            ['name' => 'CSF Culture', 'price' => 110],
            ['name' => 'Sputum Culture', 'price' => 75],
            ['name' => 'Wound Culture', 'price' => 105],
            ['name' => 'Nasal Swab Culture', 'price' => 85],
            ['name' => 'Genital Culture', 'price' => 100],
        ];

        foreach ($culturesData as $cultureData) {
            $culture = Culture::create([
                'category_id' => 1,
                'name' => $cultureData['name'],
                'price' => $cultureData['price'],
            ]);

            $branches = Branch::all();

            foreach ($branches as $branch) {
                CulturePrice::create([
                    'branch_id' => $branch['id'],
                    'culture_id' => $culture->id,
                    'price' => $cultureData['price'],
                ]);
            }
        }
    }
}
