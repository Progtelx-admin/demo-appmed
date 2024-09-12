<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentTest extends Model
{
    public $guarded = [];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'visit_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'testable_id', 'name', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'testable_id', 'id');
    }

    public function culture()
    {
        return $this->belongsTo(Culture::class, 'testable_id', 'id');
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
