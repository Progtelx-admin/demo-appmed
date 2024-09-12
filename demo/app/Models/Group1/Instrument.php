<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class Instrument extends Authenticatable
{
    use LogsActivity,Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'model', 'comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    /**
     * roles relationship
     *
     * @var array
     */
    public function branches()
    {
        return $this->hasMany(InstrumentBranch::class, 'instrument_id', 'id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Instrument was {$eventName}";
    }
}
