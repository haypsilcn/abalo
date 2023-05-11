<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends BaseModel
{
    use HasFactory;

    protected $table = "shopping_cart";
   protected $fillable = [
       "creator_id",
       "create_date"
   ];

   public function owner() {
       return $this->belongsTo(User::class);
   }

   public function shoppingCartItem() {
       return $this->hasMany(ShoppingCartItem::class);
   }
}
