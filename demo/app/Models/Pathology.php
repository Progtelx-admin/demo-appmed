<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pathology extends Model
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
        return $this->hasMany(VisitTest::class, 'visit_id', 'id');
    }

    public function getSinceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function doctors()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')->withTrashed();
    }

    public function paptest()
    {
        return $this->belongsTo(PathologyPaptest::class, 'id' , 'pathology_id');
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
