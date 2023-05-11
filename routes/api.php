<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\ShoppingCartItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/articles", [ArticleController::class, "searchAPI"]);
Route::post("/articles", [ArticleController::class, "storeAPI"]);
Route::delete("/articles/{id}", [ArticleController::class, "deleteAPI"]);

Route::post("/shoppingCart", [ShoppingCartController::class, "storeAPI"]);
Route::post("/shoppingCart/{shoppingCartID}", [ShoppingCartItemController::class, "storeAPI"]);
Route::delete("/shoppingCart/{shoppingCartID}/articles/{articleID}", [ShoppingCartItemController::class, "destroyAPI"]);

