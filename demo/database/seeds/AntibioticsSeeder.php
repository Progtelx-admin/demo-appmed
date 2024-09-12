<?php

use Illuminate\Database\Seeder;
use App\Models\Antibiotic;

class AntibioticsSeeder extends Seeder
{
    public function run()
    {
        Antibiotic::truncate();

        $antibioticsData = [
            [
                'name' => 'Amoxicillin',
                'shortcut' => 'AMX',
                'commercial_name' => 'Amoxil',
                'price' => 10.50,
                'category_id' => 1,
            ],
            [
                'name' => 'Ciprofloxacin',
                'shortcut' => 'CIP',
                'commercial_name' => 'Cipro',
                'price' => 15.75,
                'category_id' => 1,
            ],
            [
                'name' => 'Azithromycin',
                'shortcut' => 'AZI',
                'commercial_name' => 'Zithromax',
                'price' => 12.25,
                'category_id' => 2,
            ],
            [
                'name' => 'Clarithromycin',
                'shortcut' => 'CLA',
                'commercial_name' => 'Biaxin',
                'price' => 14.00,
                'category_id' => 2,
            ],
            [
                'name' => 'Doxycycline',
                'shortcut' => 'DOX',
                'commercial_name' => 'Vibramycin',
                'price' => 9.80,
                'category_id' => 1,
            ],
            [
                'name' => 'Erythromycin',
                'shortcut' => 'ERY',
                'commercial_name' => 'Eryc',
                'price' => 11.30,
                'category_id' => 2,
            ],
            [
                'name' => 'Metronidazole',
                'shortcut' => 'MET',
                'commercial_name' => 'Flagyl',
                'price' => 13.50,
                'category_id' => 1,
            ],
            [
                'name' => 'Penicillin',
                'shortcut' => 'PEN',
                'commercial_name' => 'Veetids',
                'price' => 8.75,
                'category_id' => 1,
            ],
            [
                'name' => 'Trimethoprim',
                'shortcut' => 'TMP',
                'commercial_name' => 'Primsol',
                'price' => 11.00,
                'category_id' => 2,
            ],
            [
                'name' => 'Vancomycin',
                'shortcut' => 'VAN',
                'commercial_name' => 'Vancocin',
                'price' => 16.00,
                'category_id' => 1,
            ],
        ];

        foreach ($antibioticsData as $antibioticData) {
            Antibiotic::create($antibioticData);
        }
    }
}

