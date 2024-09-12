<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use LogsActivity;

    public $guarded = [];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Setting was {$eventName}";
    }
}
