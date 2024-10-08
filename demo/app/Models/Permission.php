<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $guarded = [];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
