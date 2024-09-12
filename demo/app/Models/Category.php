<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $guarded = [];

    public function tests()
    {
        return $this->hasMany(Test::class, 'category_id', 'id');
    }

    public function testso()
    {
        return $this->hasMany(Test::class, 'category_id', 'id')->where('parent_id', 0)->orderBy('position', 'asc');
    }

    public function cultureso()
    {
        return $this->hasMany(Culture::class, 'category_id', 'id')->orderBy('position', 'asc');
    }

    public function cultures()
    {
        return $this->hasMany(Culture::class, 'category_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Use the hasMany and belongsTo relationship methods to retrieve the child categories and their parent categories respectively.

    // For example, to retrieve all the child categories of a specific category, you can use the following code:

    // $category = Category::find(1);
    // $childCategories = $category->children;

    // To retrieve the parent category of a specific category, you can use the following code:

    // $category = Category::find(1);
    // $parentCategory = $category->parent;
}
