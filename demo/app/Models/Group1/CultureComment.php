<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class CultureComment extends Model
{
    public $guarded = [];

    public function culture()
    {
        return $this->belongsTo(Culture::class, 'culture', 'id');
    }
}
