<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupService extends Model
{
    public $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id')->withTrashed();
    }
}
