<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function storeAPI(Request $request) {
        $name = $request->user;
        $email = $request->mail;

        $user = User::where("name", "=", $name)->where("email", "=", $email)->first();

        if (!$user)
            return response()->json("No user found", 404);

        if (!ShoppingCart::where("creator_id", "=", $user->id)->exists())
            ShoppingCart::create([
                "creator_id" => $user->id,
                "create_date" => now()
            ]);

        return response()->json(ShoppingCart::where("creator_id", "=", $user->id)->first(), 201);
    }
}
