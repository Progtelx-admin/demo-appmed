<?php

use Illuminate\Database\Seeder;
use App\Models\MicrobiologyTest;

class MicrobiologyTestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the data for microbiology tests
        $microbiologyTestsData = [
            [
                'name' => 'Blood Culture',
                'shortcut' => 'BC',
                'sample_type' => 'Blood',
                'price' => 75.00,
                'unit' => 'Culture Units',
                'reference_range' => 'Negative',
                'status' => 1,
                'precautions' => 'Sterile techniques must be followed.',
                'category_id' => 1,
            ],
            [
                'name' => 'Urine Culture',
                'shortcut' => 'UC',
                'sample_type' => 'Urine',
                'price' => 60.00,
                'unit' => 'Culture Units',
                'reference_range' => 'Negative',
                'status' => 1,
                'precautions' => 'Ensure proper collection of midstream urine.',
                'category_id' => 1,
            ],
            [
                'name' => 'Throat Swab Culture',
                'shortcut' => 'TSC',
                'sample_type' => 'Throat Swab',
                'price' => 55.00,
                'unit' => 'Culture Units',
                'reference_range' => 'Negative',
                'status' => 1,
                'precautions' => 'Avoid contamination with oral flora.',
                'category_id' => 1,
            ],
            [
                'name' => 'Stool Culture',
                'shortcut' => 'SC',
                'sample_type' => 'Stool',
                'price' => 70.00,
                'unit' => 'Culture Units',
                'reference_range' => 'Negative',
                'status' => 1,
                'precautions' => 'Collect fresh stool sample in a sterile container.',
                'category_id' => 1,
            ],
            [
                'name' => 'Skin Swab Culture',
                'shortcut' => 'SSC',
                'sample_type' => 'Skin Swab',
                'price' => 65.00,
                'unit' => 'Culture Units',
                'reference_range' => 'Negative',
                'status' => 1,
                'precautions' => 'Clean the skin thoroughly before swabbing.',
                'category_id' => 1,
            ],
        ];

        // Insert data into the microbiology_tests table
        foreach ($microbiologyTestsData as $testData) {
            MicrobiologyTest::create($testData);
        }
    }
}

