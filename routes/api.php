<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShoppingCartController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post("/articles/search", [ArticleController::class, "searchAPI"]);
Route::post("/articles", [ArticleController::class, "storeAPI"]);
Route::delete("/articles/{id}", [ArticleController::class, "deleteAPI"]);
Route::post("/article/{id}/sold", [ArticleController::class, "sold"]);
Route::get("articles/index", [ArticleController::class, "indexAPI"]);
Route::get("index", [ArticleController::class, "indexAPI"]);


Route::get("/categories", [CategoryController::class, "showCategories"]);

Route::post("/shoppingCart", [ShoppingCartController::class, "storeAPI"]);
Route::post("/shoppingCart/{article_id}", [ShoppingCartController::class, "addArticle"]);
Route::delete("/shoppingCart/{article_id}", [ShoppingCartController::class, "removeArticle"]);
