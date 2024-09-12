<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashInOutflow extends Model
{
    protected $fillable = [
        'cash_in', 'cash_out', 'description', 'comment', 'point_of_sale_id','created_by','updated_by'
    ];

    // public function pointOfSale()
    // {
    //     return $this->belongsTo(PointOfSale::class);
    // }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class, 'point_of_sale_id');
    }
}
