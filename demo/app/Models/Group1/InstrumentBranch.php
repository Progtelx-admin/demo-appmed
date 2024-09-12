<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class InstrumentBranch extends Model
{
    public $guarded = [];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id', 'id')->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
