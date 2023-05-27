<?php

namespace App\Models;

class Article extends BaseModel
{
    protected $table = "articles";

    protected $fillable = [
        "name",
        "price",
        "description",
        "creator_id",
        "created_at"
    ];

    public function user(){
        return $this->belongsTo(User::class, "creator_id");
    }

    public function cart() {
        return $this->belongsToMany(ShoppingCart::class, "shopping_cart_item", "article_id", "shopping_cart_id");
    }

    public function category() {
        return $this->belongsToMany(Category::class, "article_has_category", "article_id", "category_id");
    }
}
