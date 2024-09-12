<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    public $guarded = [];

    /**
     * Relationships
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
    }
}
