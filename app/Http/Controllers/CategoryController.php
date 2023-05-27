<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showAllCategories() {
        $categories = Category::query()
            ->select("name")->get();

        return view("layout", [
            "categories" => $categories
        ]);
    }

    public function showCategories() {
        return response()->json(
            Category::query()->select("name")->get()
        );
    }
}
