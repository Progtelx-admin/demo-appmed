<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMicrobiologyTestAntibioticResult extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function antibiotic()
    {
        return $this->belongsTo(Antibiotic::class);
    }
}



