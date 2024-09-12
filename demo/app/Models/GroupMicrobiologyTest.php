<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GroupMicrobiologyTest extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function microbiologyTest()
    {
        return $this->belongsTo(MicrobiologyTest::class, 'test_id', 'id')->withTrashed();
    }

    public function results()
    {
        return $this->hasMany(GroupMicrobiologyTestResult::class, 'group_microbiology_test_id', 'id')->orderBy('id', 'asc');
    }

}
