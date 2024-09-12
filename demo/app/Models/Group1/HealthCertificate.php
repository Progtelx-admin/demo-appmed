<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class HealthCertificate extends Model
{
    use LogsActivity;

    public $guarded = [];

    public $appends = ['since'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    public function visit_type()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id');
    }

    public function healthcertificate_tests()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id');
    }

    public function doctors()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Doctor::class);
    }

    public function tests()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Test::class);
    }

    public function cultures()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Culture::class);
    }

    public function packages()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Package::class);
    }

    public function antibiotics()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id')
            ->where('testable_type', \App\Models\Antibiotic::class);
    }

    public function diagnosis()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id');
    }

    public function anamnesis()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id');
    }

    public function therapy()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id');
    }

    public function recommendation()
    {
        return $this->hasMany(HealthCertificateTest::class, 'visit_id', 'id');
    }

    public function getSinceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Health Certificate was {$eventName}";
    }
}
