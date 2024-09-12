<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Contract extends Model
{
    use LogsActivity;
    use SoftDeletes;

    public $guarded = [];

    public function tests()
    {
        return $this->hasMany(ContractPrice::class, 'contract_id', 'id')
            ->where('priceable_type', \App\Models\Test::class)
            ->orderBy('id', 'asc');
    }

    public function antibiotics()
    {
        return $this->hasMany(ContractPrice::class, 'contract_id', 'id')
            ->where('priceable_type', \App\Models\Antibiotic::class)
            ->orderBy('id', 'asc');
    }

    public function cultures()
    {
        return $this->hasMany(ContractPrice::class, 'contract_id', 'id')
            ->where('priceable_type', \App\Models\Culture::class)
            ->orderBy('id', 'asc');
    }

    public function packages()
    {
        return $this->hasMany(ContractPrice::class, 'contract_id', 'id')
            ->where('priceable_type', \App\Models\Package::class)
            ->orderBy('id', 'asc');
    }

    public function services()
    {
        return $this->hasMany(ContractPrice::class, 'contract_id', 'id')
            ->where('priceable_type', \App\Models\Service::class)
            ->orderBy('id', 'asc');
    }

    public function prices()
    {
        return $this->hasMany(ContractPrice::class, 'contract_id', 'id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Contract was {$eventName}";
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
