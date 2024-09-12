<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryBranch extends Model
{
    public $guarded = [];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id')->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
