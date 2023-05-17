<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingCart extends BaseModel
{
    use HasFactory;

    protected $table = "shopping_cart";
    protected $fillable = [
        "creator_id"
    ];

    public function owner() {
        return $this->belongsTo(User::class, "creator_id");
    }

    public function items() {
        return $this->belongsToMany(Article::class, "shopping_cart_item", "shopping_cart_id", "article_id");
    }
}
