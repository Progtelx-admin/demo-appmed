<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::truncate();

        Branch::create([
            'name' => 'Main Branch',
            'address' => 'USA',
            'phone' => '00',
            'lat' => '27.77',
            'lng' => '30.88',
            'zoom_level' => 8,
        ]);

        Branch::create([
            'name' => 'Master Branch',
            'address' => 'Canada',
            'phone' => '01',
            'lat' => '45.42',
            'lng' => '-75.69',
            'zoom_level' => 7,
        ]);
    }
}
