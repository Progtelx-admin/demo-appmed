<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CultureOption extends Model
{
    use LogsActivity;
    use SoftDeletes;

    public $guarded = [];

    public function childs()
    {
        return $this->hasMany(CultureOption::class, 'parent_id', 'id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Culture option was {$eventName}";
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
