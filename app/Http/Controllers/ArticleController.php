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

        return view("articles", [
            "results" => $results,
            "keyword" => $keyword,
            "images" => $images,

        ]);
    }

    public function index() {
        $results = $this->show();

        return view("results", [
            "results" => $results
        ]);
    }

}
