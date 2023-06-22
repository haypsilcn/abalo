<?php

use App\Events\MaintenanceNotification;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
Route::get("/user", [AuthController::class, "isLoggedIn"]);

Route::get('/', function () {
    return view('welcome');
});

Route::get("/layout",[CategoryController::class, "showAllCategories"])->name("showCategory");
Route::get("/homepage/", function () {
    return view("homepage");
})->name("homepage");

Route::get("/login", function () {
    return Session::has("user") ?  redirect("homepage") : view("login");
});
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
//Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isLoggedIn'])->name('haslogin');

Route::get("/article/search", [ArticleController::class, "search"])->name("articleSearch");
Route::get("/article/create", function () {
    return Session::has("user") ? view("article/create") : redirect("login");
});
Route::post("/article", [ArticleController::class, "store"]);
Route::get("/article", function () {
    return redirect()->route("articleIndex");
});
Route::get("/articles", function () {
    return redirect()->route("articleIndex");
});
Route::get("/article/index", [ArticleController::class, "index"])->name("articleIndex");

Route::get("/maintenance", function () {
    event(new MaintenanceNotification());
});
