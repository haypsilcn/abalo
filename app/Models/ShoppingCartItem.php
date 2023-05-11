<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCartItem extends BaseModel
{
    use HasFactory;
    protected $table = "shopping_cart_item";

    protected $fillable = [
        "shopping_cart_id",
        "article_id",
        "create_date"
    ];

    public function article() {
        return $this->hasMany(Article::class);
    }

    public function shoppingCart() {
        return $this->belongsTo(ShoppingCart::class);
    }
}
