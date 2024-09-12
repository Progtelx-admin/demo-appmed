<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Group extends Model
{
    use LogsActivity;

    public $guarded = [];

    // public function all_tests2()
    // {
    //     return $this->hasMany(GroupTest::class,'group_id','id') ->with('test');
    // }

    public function all_tests()
    {
        return $this->hasMany(GroupTest::class, 'group_id', 'id')->orderBy('position', 'asc');
    }

    public function tests()
    {
        return $this->hasMany(GroupTest::class, 'group_id', 'id')
            ->where('package_id', null);
    }

    public function all_cultures()
    {
        return $this->hasMany(GroupCulture::class, 'group_id', 'id');
    }

    public function cultures()
    {
        return $this->hasMany(GroupCulture::class, 'group_id', 'id')
            ->where('package_id', null);
    }

    public function all_services()
    {
        return $this->hasMany(GroupService::class, 'group_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(GroupService::class, 'group_id', 'id')
            ->where('package_id', null);
    }

    public function all_microbiology_tests()
    {
        return $this->hasMany(GroupMicrobiologyTest::class, 'group_id', 'id');
    }

    public function microbiology_tests()
    {
        return $this->hasMany(GroupMicrobiologyTest::class, 'group_id', 'id')
                    ->where('package_id', null);
    }

    public function packages()
    {
        return $this->hasMany(GroupPackage::class, 'group_id', 'id');
    }

    public function all_antibiotics()
    {
        return $this->hasMany(GroupAntibiotic::class, 'group_id', 'id');
    }

    public function antibiotics()
    {
        return $this->hasMany(GroupAntibiotic::class, 'group_id', 'id')
            ->where('package_id', null);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')->withTrashed();
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id')->withTrashed();
    }

    public function payments()
    {
        return $this->hasMany(GroupPayment::class, 'group_id', 'id');
    }

    public function consumptions()
    {
        return $this->hasMany(ProductConsumption::class, 'group_id', 'id');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withTrashed();
    }

    public function signed_by_user()
    {
        return $this->belongsTo(User::class, 'signed_by', 'id')->withTrashed();
    }

    public function signed_by_user2()
    {
        return $this->belongsTo(User::class, 'signed_by2', 'id')->withTrashed();
    }

    public function signed_by_user3()
    {
        return $this->belongsTo(User::class, 'signed_by3', 'id')->withTrashed();
    }

    public function signed_by_user4()
    {
        return $this->belongsTo(User::class, 'signed_by4', 'id')->withTrashed();
    }

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class, 'pos');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Group test was {$eventName}";
    }

    public function getMergedItemsAttribute()
    {
        // Eager load related models if not already done
        $this->loadMissing(['tests', 'cultures', 'services', 'packages', 'packages.tests', 'packages.cultures']);

        // Collect all items first
        $items = $this->tests->pluck('test.name')
            ->concat($this->cultures->pluck('culture.name'))
            ->concat($this->services->pluck('service.name'));

        // Flatten the nested loop for packages
        $packageItems = $this->packages->flatMap(function ($package) {
            return $package->tests->pluck('test.name')
                ->concat($package->cultures->pluck('culture.name'));
        });

        // Merge all items at once
        return $items->concat($packageItems);
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
