<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\User;
use Illuminate\Http\Request;

class ShoppingCartItemController extends Controller
{
    public function storeAPI(Request $request, $articleID) {

        if (empty(User::find($request->creator_id)))
            return response()->json("No user found", 404);
        if (empty(ShoppingCart::find($request->id)))
            return response()->json("No shopping found", 404);
        if (!ShoppingCart::where("id", "=", $request->id)
            ->where("creator_id", "=", $request->creator_id)->exists())
            return response()->json("Unauthorized user for shopping cart id #" . $request->id, 401);
        if (empty(Article::find($articleID)))
            return response()->json("No article found", 404);

        if (!ShoppingCartItem::where("shopping_cart_id", "=", $request->id)->where("article_id", "=", $articleID)->exists())
            ShoppingCartItem::create([
                "shopping_cart_id" => $request->id,
                "article_id" => $articleID,
                "create_date" => now()
            ]);
        return response()->json(ShoppingCartItem::where("shopping_cart_id", "=", $request->id)
            ->where("article_id", "=", $articleID)->first(), 201);
    }

    public function destroyAPI($shoppingCartID, $articleID) {
        if (empty(Article::find($articleID)))
            return response()->json("No article found", 404);
        if (empty(ShoppingCart::find($shoppingCartID)))
            return response()->json("No shopping cart found", 404);
        if (!ShoppingCartItem::where("shopping_cart_id", "=", $shoppingCartID)
            ->where("article_id", "=", $articleID)->exists())
            return response()->json("Article id #" . $articleID . "not found in shopping cart id #" . $shoppingCartID, 404);

        $item = ShoppingCartItem::where("shopping_cart_id", "=", $shoppingCartID)
            ->where("article_id", "=", $articleID)->first();

        if ($item->delete())
            return response()->json("Article id #" . $articleID . " successfully removed from shopping cart id #" . $shoppingCartID, 200);
        else
            return response()->json("Error happened during remove article from shopping cart. Try again later.", 403);
    }
}
