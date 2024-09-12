<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class MicrobiologyTest extends Model
{
    use SoftDeletes;
    use LogsActivity;


    public $guarded = [];
    // protected $fillable = [
    //     'name', 'sample_type', 'price', 'precautions','category_id'
    // ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function components()
    {
        return $this->hasMany(MicrobiologyTest::class, 'parent_id', 'id')->orderBy('id', 'asc');
    }

    public function sub_analyses()
    {
        return $this->hasMany(MicrobiologyTest::class, 'parent_id', 'id')->where('separated', 1);
    }

    public function options()
    {
        return $this->hasMany(MicrobiologyTestOption::class, 'test_id', 'id');
    }

    public function test_price()
    {
        return $this->hasOne(MicrobiologyTestPrice::class, 'test_id', 'id')
                    ->where('branch_id', session('branch_id'));
    }

    public function prices()
    {
        return $this->hasMany(MicrobiologyTestPrice::class, 'test_id', 'id');
    }

    public function contract_prices()
    {
        return $this->morphMany(ContractPrice::class, 'priceable');
    }

    public function reference_ranges()
    {
        return $this->hasMany(MicrobiologyTestReferenceRange::class, 'test_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(MicrobiologyTestComment::class, 'test_id', 'id')->orderBy('id', 'asc');
    }

    public function consumptions()
    {
        return $this->morphMany(MicrobiologyTestConsumption::class, 'testable')->orderBy('id', 'asc');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Microbiology Test was {$eventName}";
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(['log_name' => 'users']);
    }

}
