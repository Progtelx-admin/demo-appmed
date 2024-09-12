<?php


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PointOfSale;

class PointOfSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PointOfSale::truncate(); // Clear existing records (if any)

        // Create a new point of sale record
        PointOfSale::create([
            'pos_name' => 'POS 1 PROG',
            'pos_location' => 'Dragodan',
            'cash_in_hand' => 5000.00,
            'pantheon_id' => 'x',
            'issuer_id' => 'x',
        ]);
    }
}
