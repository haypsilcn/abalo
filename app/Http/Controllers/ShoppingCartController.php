<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * create a shopping cart
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAPI(Request $request) {
        $user = User::where("name", $request->user)->where("email", $request->mail)->first();

        if (!$user)
            return response()->json("No user found", 404);

        if (empty($user->cart))
            $user->cart()->create();

        return response()->json($user->cart()->first(), 201);
    }

    public function addArticle(Request $request, $articleID) {
        $user = User::where("name", $request->user)->where("email", $request->mail)->first();

        if (!$user)
            return response()->json("No user found", 404);

        if (!$user->cart->items->contains($articleID))
            $user->cart->items()->attach($articleID);

        return response()->json($user->cart->items()->where("article_id", $articleID)->first(), 201);
    }

    public function removeArticle(Request $request, $articleID) {
        $user = User::where("name", $request->user)->where("email", $request->mail)->first();

        if (!$user)
            return response()->json("No user found", 404);

        if ($user->cart->items->contains($articleID))
            $user->cart->items()->detach($articleID);

        return response()->json("Article id #" . $articleID . " removed from cart");
    }
}
