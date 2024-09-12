<?php

use App\Models\Branch;
use App\Models\Instrument;
use App\Models\InstrumentBranch;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instrument::truncate();

        $instrument = Instrument::create([
            'name' => 'Integra',
            'model' => 'Roche',
            'comment' => 'Roche device',
        ]);

        //asign branches to instrument
        $branches = Branch::all();
        foreach ($branches as $branch) {
            InstrumentBranch::create([
                'branch_id' => $branch['id'],
                'instrument_id' => $instrument['id'],
            ]);
        }

    }
}
