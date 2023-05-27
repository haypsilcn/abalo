<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ArticleController extends Controller
{
    private function articleImg() {

        $files = \File::files("img/articelimages");
        $images = [];

        // create array images with images = [ imgID => path ]
        foreach ($files as $file) {
            $images[pathinfo($file, PATHINFO_FILENAME)] =
                        $file->getPathname();
            }

        return $images;
    }

    public function search() {
        return view("article/search");
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

    /**
     * trigger while typing in search box
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAPI(Request $request) {
        $keyword = $request->search;
        $quickSearch = $request->quickSearch;
        $skipped = $request->currentPage - 1;

        if (strlen($keyword) == 0)
            return response()->json("Empty keyword is not allowed.", 422);

        // ilike for insensitive case

            $results = Article::where("name", "ilike", "%".strtolower($keyword)."%")
                ->orderBy("id")->take(5)->get();
        if (!$quickSearch) {
            $total = Article::where("name", "ilike", "%".strtolower($keyword)."%")
                ->orderBy("id")->get();
            $results = Article::where("name", "ilike", "%".strtolower($keyword)."%")
                ->orderBy("id")->skip($skipped * 5)->take(5)->get();
//            $results["total"] = count($total);
        }

//        return response()->json(compact("results"));


        $images = $this->articleImg();

        $results = $results->map(function ($result) use ($images) {
            // change the creator id in column 'creator_id' into creator name
            $result->creator_id = User::find($result->creator_id)->name;

            // fix img path to correct form if image path exist
            // else set path = ""
            $result["image"] = isset($images[$result->id]) ? ("/" . str_replace("\\", "/", $images[$result->id])) : "";

            return $result;
        });

        if (count($results) == 0)
            return response()->json("No article found", 404);

        if ($quickSearch)
            return response()->json($results);
        else {
            return response()->json([
                "results" => $results,
                "pages" => ceil(count($total)/5)]);
        }

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
