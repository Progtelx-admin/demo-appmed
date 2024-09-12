<?php

namespace App\Models\Group1;

use Illuminate\Database\Eloquent\Model;

class GroupCulture extends Model
{
    public $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function culture()
    {
        return $this->belongsTo(Culture::class, 'culture_id', 'id')->withTrashed();
    }

    public function antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->orderBy('id', 'asc');
    }

    public function high_antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity', __('Sensitiv'));
    }

    public function moderate_antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity', __('Intermediar'));
    }

    public function resident_antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity', __('Rezistent'));
    }

    public function high_antibiotics2()
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity2', __('Sensitiv'));
    }

    public function moderate_antibiotics2()
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity2', __('Intermediar'));
    }

    public function resident_antibiotics2()
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity2', __('Rezistent'));
    }

    public function culture_options()
    {
        return $this->hasMany(GroupCultureOption::class, 'group_culture_id', 'id');
    }
}
