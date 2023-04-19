<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function connectTable() {
        return DB::table("results");
    }

    public function articleImg() {

        $files = \File::files("img/articelimages");
        $images = [];

        // create array images with images = [ imgID => path ]
        foreach ($files as $file) {
            $images[pathinfo($file, PATHINFO_FILENAME)] =
                        $file->getPathname();
            }

        return $images;
    }
    public function search(Request $request) {

        // get keyword from input with name="search" from article.blade.php
        $keyword = $request->search;

        // WHY NOT WORKING? ERROR: UNDEFINED PROPERTY
        /*$results = $this->connectTable()
            ->select("results.*")
            ->join("users", "results.creator_id", "=", "users.id")
            ->where("name", "like", "%".$keyword."%")
            ->get();*/

        // ilike for insensitive case
        $results = Article::query()
            ->where("name", "ilike", "%".strtolower($keyword)."%")
            ->get();


        $images = $this->articleImg();

        return view("article/search", [
            "results" => $results,
            "keyword" => $keyword,
            "images" => $images,
        ]);
    }

    public function create() {
        return view("article/create");
    }

    public function store(Request $request) {
        $name = $request->articleName;
        $price = $request->price;
        $description = $request->description;

        // bypass not-null constraint on creator_id & description
        if (strlen($description) == 0)
            $description = "";
        $creator = 2;

        $alreadyExist = Article::query()
            ->where("name", "like", $name)
            ->where("creator_id", "=", $creator)
            ->count();


        if ($alreadyExist != 0) // if insert not success then return to create view with error msg
            return redirect()->route("articleCreate")
                ->with("fail", "The article '" . $name . "' is already exist. Please try another one.");
        else {
            Article::query()
                ->insert([
                    "name" => $name,
                    "price" => $price,
                    "description" => $description,
                    "creator_id" => $creator,
                    "created_at" => now()
                ]);
            return redirect()->route("articleSearch");

        }
    }

    public function view() {
        $results = Article::all();
        $images = $this->articleImg();

        return view("article/view", [
            "results" => $results
            ]);
    }
}
