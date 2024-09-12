<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'module_id', 'id');
    }
}
