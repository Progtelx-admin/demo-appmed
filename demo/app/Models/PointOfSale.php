<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointOfSale extends Model
{
    protected $fillable = [
        'pos_name', 'pos_location', 'cash_in_hand','pantheon_id','issuer_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
