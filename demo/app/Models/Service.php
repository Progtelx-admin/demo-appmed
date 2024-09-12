<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Service extends Model
{
    use LogsActivity;
    use SoftDeletes;

    public $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function service_price()
    {
        return $this->hasOne(ServicePrice::class, 'service_id', 'id')
            ->where('branch_id', session('branch_id'));
    }

    public function prices()
    {
        return $this->hasMany(ServicePrice::class, 'service_id', 'id');
    }

    public function contract_prices()
    {
        return $this->morphMany(ContractPrice::class, 'priceable');
    }

    public function comments()
    {
        return $this->hasMany(ServiceComment::class, 'service_id', 'id')->orderBy('id', 'asc');
    }

    public function consumptions()
    {
        return $this->morphMany(TestConsumption::class, 'testable')->orderBy('id', 'asc');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Service was {$eventName}";
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Test::class, 'service_id', 'id')->withTrashed();
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
