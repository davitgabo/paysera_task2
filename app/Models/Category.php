<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function parents()
    {
        return $this->belongsToMany(Category::class, 'category_relationship', 'child_id', 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(Category::class, 'category_relationship', 'parent_id', 'child_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category');
    }
}
