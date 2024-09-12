<?php

use App\Models\Branch;
use App\Models\Laboratory;
use App\Models\LaboratoryBranch;
use Illuminate\Database\Seeder;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Laboratory::truncate();

        $laboratory = Laboratory::create([
            'ResultDetailPK' => 'Integra',
            'model' => 'Roche',
            'comment' => 'Roche device',
        ]);

        //asign branches to laboratory
        $branches = Branch::all();
        foreach ($branches as $branch) {
            LaboratoryBranch::create([
                'branch_id' => $branch['id'],
                'laboratory_id' => $laboratory['id'],
            ]);
        }

    }
}
