<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class TestReferenceRange extends Model
{
    public $guarded = [];

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }
}
