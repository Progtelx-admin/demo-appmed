<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

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
}
