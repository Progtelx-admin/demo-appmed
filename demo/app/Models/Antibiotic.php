<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Antibiotic extends Model
{
    use LogsActivity;
    use SoftDeletes;

    public $guarded = [];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Antibiotic was {$eventName}";
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
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
