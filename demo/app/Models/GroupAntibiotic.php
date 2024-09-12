<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAntibiotic extends Model
{
    public $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function antibiotic()
    {
        return $this->belongsTo(Antibiotic::class, 'antibiotic_id', 'id')->withTrashed();
    }
}
