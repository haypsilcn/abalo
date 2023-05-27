<?php

namespace App\Models;


class Category extends BaseModel
{
    protected $table = "categories";
    protected $fillable = [
        "name",
        "parent"
    ];

    public function articles() {
        return $this->belongsToMany(Article::class, "article_has_category", "category_id", "article_id");
    }
}
