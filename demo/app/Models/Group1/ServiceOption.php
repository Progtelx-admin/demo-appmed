<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOption extends Model
{
    use SoftDeletes;

    public $guarded = [];
}
