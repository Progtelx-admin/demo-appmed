<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrobiologyTestReferenceRange extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo(MicrobiologyTest::class, 'test_id', 'id');
    }
}
