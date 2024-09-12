<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class Laboratory extends Authenticatable
{
    use LogsActivity,Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ResultDetailPK', 'ResultMasterFK', 'AnalyzerNo', 'SampleNo', 'ResultTransferDtTm', 'ResultAnalysisDtTm', 'AnalyzerTestParam', 'ResultValue', 'ResultValue2', 'ResultValueFlag', 'SampleType', 'ResultUnit', 'ReferenceRange', 'IsResultValueRead', 'LIMSTestParam', 'LIMSData1', 'LIMSData2', 'LIMSData3',
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
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Laboratory was {$eventName}";
    }
}
