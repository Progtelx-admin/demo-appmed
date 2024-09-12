<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class ContractPrice extends Model
{
    public $guarded = [];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function priceable()
    {
        return $this->morphTo();
    }
}
