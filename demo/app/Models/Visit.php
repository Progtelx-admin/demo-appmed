<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Visit extends Model
{
    use LogsActivity;

    public $guarded = [];

    public $appends = ['since'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')->withTrashed();
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    public function visit_type()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id');
    }

    public function visit_tests()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id');
    }

    public function doctors()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Doctor::class);
    }

    public function tests()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Test::class);
    }

    public function cultures()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Culture::class);
    }

    public function services()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Service::class);
    }

    public function packages()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Package::class);
    }

    public function antibiotics()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Antibiotic::class);
    }

    public function diagnosis()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id');
    }

    public function anamnesis()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id');
    }

    public function therapy()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id');
    }

    public function recommendation()
    {
        return $this->hasMany(VisitTest::class, 'visit_id', 'id');
    }

    public function getSinceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Visit was {$eventName}";
    }

    public function signed_by_user()
    {
        return $this->belongsTo(User::class, 'signed_by', 'id')->withTrashed();
    }

    /**
     * Get the options for the user activity logging.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(['log_name' => 'users']);
    }
}
