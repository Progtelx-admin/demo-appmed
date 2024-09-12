<?php

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the data for packages
        $packagesData = [
            [
                'name' => 'Basic Package',
                'shortcut' => 'BP',
                'price' => 100.00,
                'precautions' => 'This package includes basic medical tests.',
                'pantheon_id' => 'BASIC-001',
            ],
            [
                'name' => 'Advanced Package',
                'shortcut' => 'AP',
                'price' => 200.00,
                'precautions' => 'This package includes advanced medical tests.',
                'pantheon_id' => 'ADVANCED-001',
            ],
        ];

        // Insert data into the packages table
        foreach ($packagesData as $packageData) {
            Package::create($packageData);
        }
    }
}




