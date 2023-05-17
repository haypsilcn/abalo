<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ArticleController extends Controller
{
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
            return response()->json("The article '" . $name . "' is already exist. Please try another one.", 409);

        Article::query()
            ->insert([
                "name" => $name,
                "price" => $price,
                "description" => $description,
                "creator_id" => $creator,
                "created_at" => now()
            ]);

        return response()->json("New article successfully created", 201);
    }

    public function index() {
        $results = Article::all();

        return view("article/index", [
            "results" => $results
            ]);
    }

    public function searchAPI(Request $request) {
        $keyword = $request->search;

        if (strlen($keyword) == 0)
            return response()->json("Empty keyword is not allowed.", 422);

        // ilike for insensitive case
        $results = Article::where("name", "ilike", "%".strtolower($keyword)."%")
            ->get();

        if (count($results) == 0)
            return response()->json("No article found", 404);

        return response()->json($results, 200);
    }

    /** store article
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAPI(Request $request) {
        $creator = $request->user;
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;

        if (!$creator)
            return response()->json("No user was given.", 401);

        $userValid = User::where("id", "=", $creator["id"])->first();
        if (!$userValid)
            return response()->json("Invalid user.", 401);

        if (strlen($name) == 0 || !is_int($price) || $price <= 0 || strlen($description) == 0)
            return response()->json("Invalid input. Please check the article name, price and description again.", 422);

        $alreadyExist = Article::query()
            ->where("name", "like", $name)
            ->where("creator_id", "=", $creator["id"])
            ->count();
        if ($alreadyExist != 0)
            return response()->json("Duplicated article.", 409);

        $newArticle = Article::create([
                "name" => $name,
                "price" => $price,
                "description" => $description,
                "creator_id" => $creator["id"],
                "created_at" => now()
            ]);

        return response()->json([
            "id" => $newArticle->id],
            201);
    }

    /**
     * delete article
     * @param Request $request
     * @param $articleID
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAPI(Request $request, $articleID) {
        $creator = $request->user;

        if (!$creator)
            return response()->json("No user was given.", 401);

        $userValid = User::where("id", "=", $creator["id"])->first();
        if (!$userValid)
            return response()->json("Invalid user.", 401);

        $article = Article::where("id", "=", $articleID)
            ->where("creator_id", "=", $creator["id"])->first();

        if (!$article)
            return response()->json("No article found.", 404);

        if ($article->delete())
            return response()->json("ArticleID #" . $articleID . " was successfully deleted", 200);
        else
            return response()->json("Error happened during delete article. Please try again later", 403);

    }
}
