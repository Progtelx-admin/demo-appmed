<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitTest extends Model
{
    public $guarded = [];

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'testable_id', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'testable_id', 'id');
    }

    public function culture()
    {
        return $this->belongsTo(Culture::class, 'testable_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'testable_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'testable_id', 'id');
    }

    public function antibiotic()
    {
        return $this->belongsTo(Antibiotic::class, 'testable_id', 'id');
    }

    public function diagnose()
    {
        return $this->belongsTo(Diagnose::class, 'testable_id', 'id');
    }
}
