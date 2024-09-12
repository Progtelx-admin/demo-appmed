<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends Model
{
    use LogsActivity;

    public $guarded = [];

    public $timestamps = false;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Currency was {$eventName}";
    }
}
