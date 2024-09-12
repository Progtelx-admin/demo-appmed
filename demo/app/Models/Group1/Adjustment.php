<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    public $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    public function products()
    {
        return $this->hasMany(AdjustmentProduct::class, 'adjustment_id', 'id')->orderBy('id', 'asc');
    }
}
