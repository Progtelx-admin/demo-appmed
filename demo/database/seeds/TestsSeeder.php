<?php

use App\Models\Branch;
use App\Models\Test;
use App\Models\TestPrice;
use Illuminate\Database\Seeder;

class TestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Test::truncate();
        TestPrice::truncate();

        // Creating Complete Blood Count Test
        $cbcTest = Test::create([
            'category_id' => 1,
            'name' => 'Complete Blood Count',
            'shortcut' => 'CBC',
            'price' => '30',
            'sample_type' => 'blood',
            'parent_id' => 0,
        ]);

        // Components for Complete Blood Count Test
        $cbcComponents = [
            ['name' => 'hgb-hemoglobin', 'unit' => 'g/dl'],
            ['name' => 'hct-hematocrit', 'unit' => '%'],
            ['name' => 'RBC-Erythrocytes', 'unit' => 'million/µl'],
            ['name' => 'MCV', 'unit' => 'fl'],
            ['name' => 'MCH', 'unit' => 'pg'],
            ['name' => 'MCHC', 'unit' => 'g/dl'],
            ['name' => 'RDW-CV', 'unit' => '%'],
            ['name' => 'pit-platelet', 'unit' => '10^3/µ'],
            ['name' => 'MPV', 'unit' => 'fl'],
            ['name' => 'PCT-PLATELETCRIT', 'unit' => '%'],
            ['name' => 'PDW', 'unit' => '%'],
        ];

        // Inserting components for Complete Blood Count Test
        foreach ($cbcComponents as $component) {
            $component['category_id'] = 1;
            $component['parent_id'] = $cbcTest->id;
            $component['type'] = 'text';
            $component['title'] = false;
            $component['sample_type'] = 'blood';
            $component['reference_range'] = '';
            $component['separated'] = false;
            Test::create($component);
        }

        // Assigning prices for Complete Blood Count Test
        $branches = Branch::all();
        foreach ($branches as $branch) {
            TestPrice::create([
                'branch_id' => $branch->id,
                'test_id' => $cbcTest->id,
                'price' => $cbcTest->price,
            ]);
        }

        // Additional tests with fewer components
        $additionalTests = [
            [
                'name' => 'Urinalysis',
                'shortcut' => 'UA',
                'price' => '20',
                'sample_type' => 'urine',
                'components' => [
                    ['name' => 'pH', 'unit' => ''],
                    ['name' => 'Protein', 'unit' => ''],
                    ['name' => 'Glucose', 'unit' => ''],
                    ['name' => 'Ketones', 'unit' => ''],
                ]
            ],
            [
                'name' => 'Stool Examination',
                'shortcut' => 'SE',
                'price' => '25',
                'sample_type' => 'stool',
                'components' => [
                    ['name' => 'Occult Blood', 'unit' => ''],
                    ['name' => 'Consistency', 'unit' => ''],
                ]
            ],
            [
                'name' => 'Urea and Electrolytes',
                'shortcut' => 'U&E',
                'price' => '35',
                'sample_type' => 'blood',
                'components' => [
                    ['name' => 'Urea', 'unit' => 'mg/dl'],
                    ['name' => 'Sodium', 'unit' => 'mmol/L'],
                    ['name' => 'Potassium', 'unit' => 'mmol/L'],
                    ['name' => 'Chloride', 'unit' => 'mmol/L'],
                ]
            ],
            [
                'name' => 'Thyroid Function Tests',
                'shortcut' => 'TFTs',
                'price' => '40',
                'sample_type' => 'blood',
                'components' => [
                    ['name' => 'TSH', 'unit' => 'mU/L'],
                    ['name' => 'T4', 'unit' => 'µg/dL'],
                    ['name' => 'T3', 'unit' => 'ng/dL'],
                ]
            ],
        ];

        foreach ($additionalTests as $testData) {
            // Creating test
            $test = Test::create([
                'category_id' => 1,
                'name' => $testData['name'],
                'shortcut' => $testData['shortcut'],
                'price' => $testData['price'],
                'sample_type' => $testData['sample_type'],
                'parent_id' => 0,
            ]);

            // Inserting components for the test
            foreach ($testData['components'] as $component) {
                $component['category_id'] = 1;
                $component['parent_id'] = $test->id;
                $component['type'] = 'text';
                $component['title'] = false;
                $component['sample_type'] = $testData['sample_type'];
                $component['reference_range'] = '';
                $component['separated'] = false;
                Test::create($component);
            }

            // Assigning prices for the test
            foreach ($branches as $branch) {
                TestPrice::create([
                    'branch_id' => $branch->id,
                    'test_id' => $test->id,
                    'price' => $testData['price'],
                ]);
            }
        }
    }
}

