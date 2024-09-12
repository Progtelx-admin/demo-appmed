<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrobiologyTestComment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function microbiologyTest()
    {
        return $this->belongsTo(MicrobiologyTest::class, 'test_id', 'id');
    }
}

