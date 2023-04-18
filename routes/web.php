<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/layout",[CategoryController::class, "showAllCategories"])->name("showCategory");

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isLoggedIn'])->name('haslogin');

Route::get("article/search", [ArticleController::class, "search"])->name("articleSearch");
Route::get("article/create", [ArticleController::class, "create"])->name("articleCreate");
Route::post("/article", [ArticleController::class, "store"]);
Route::get("article/view", [ArticleController::class, "view"])->name("articleView");

