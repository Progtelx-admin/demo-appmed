<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class TestComment extends Model
{
    public $guarded = [];

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }
}
