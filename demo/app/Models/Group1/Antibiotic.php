<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Antibiotic extends Model
{
    use LogsActivity;
    use SoftDeletes;

    public $guarded = [];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Antibiotic was {$eventName}";
    }
}
