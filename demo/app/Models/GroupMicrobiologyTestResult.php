<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMicrobiologyTestResult extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function component()
    {
        return $this->belongsTo(MicrobiologyTest::class, 'test_id', 'id')->withTrashed();
    }

    public function groupMicrobiologyTest()
    {
        return $this->belongsTo(GroupMicrobiologyTest::class, 'group_microbiology_test_id', 'id');
    }

    // per PDF e ri
    public function test()
    {
        return $this->belongsTo(MicrobiologyTest::class);
    }
    //LM


    public function antibiotics()
    {
        return $this->hasMany(GroupMicrobiologyTestAntibioticResult::class, 'group_microbiology_test_result_id', 'id')->orderBy('id', 'asc');
    }

    public function high_antibiotics()
    {
        return $this->hasMany(GroupMicrobiologyTestAntibioticResult::class, 'group_microbiology_test_result_id', 'id')->where('sensitivity', __('Sensitiv'));
    }

    public function moderate_antibiotics()
    {
        return $this->hasMany(GroupMicrobiologyTestAntibioticResult::class, 'group_microbiology_test_result_id', 'id')->where('sensitivity', __('Intermediar'));
    }

    public function resident_antibiotics()
    {
        return $this->hasMany(GroupMicrobiologyTestAntibioticResult::class, 'group_microbiology_test_result_id', 'id')->where('sensitivity', __('Rezistent'));
    }

    public function reference_range()
    {
        $patient = Patient::find($this->groupMicrobiologyTest->group->patient_id);

        if (isset($patient)) {
            $referenceRange = MicrobiologyTestReferenceRange::where('test_id', $this->test_id)
            ->where('age_from_days', '<=', $patient['age_days'])
            ->where('age_to_days', '>=', $patient['age_days'])
            ->where(function ($query) use ($patient) {
                return $query->where('gender', $patient['gender'])
                            ->orWhere('gender', 'both');
            })
            ->first();

            return $referenceRange;
        }
    }
}
