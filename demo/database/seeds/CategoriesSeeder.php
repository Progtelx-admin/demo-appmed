<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $categoriesData = [
            ['name' => 'Health Checkup'],
            ['name' => 'Microbiology'],
            ['name' => 'Radiology'],
            ['name' => 'Laboratory Tests'],
            ['name' => 'Antibiotics'],
            ['name' => 'Consultation'],
            ['name' => 'Medical Procedures'],
            ['name' => 'Diagnostics'],
            ['name' => 'Pharmacy'],
            ['name' => 'Surgery'],
            ['name' => 'Hematology'],
        ];

        foreach ($categoriesData as $categoryData) {
            Category::create($categoryData);
        }
    }
}
