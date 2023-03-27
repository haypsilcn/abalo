<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // delete all records in table if exists
        User::truncate();
        Article::truncate();
        Category::truncate();



        $userCsvFile = fopen(base_path("database/data/csv/user.csv"), "r");
        $articleCsvFile = fopen(base_path("database/data/csv/article.csv"), "r");
        $categoryCsvFile = fopen(base_path("database/data/csv/articlecategory.csv"), "r");


        // importing user.csv
        $firstLine = true;
        while (($data = fgetcsv($userCsvFile,1000, ";")) !== false) {
            if (!$firstLine)
                User::create([
                    "name" => $data["1"],
                    "email" => $data["3"],
                    "password" => $data["2"]
                ]);
            $firstLine = false;
        }
        fclose($userCsvFile);

        // importing article.csv
        $firstLine = true;
        while (($data = fgetcsv($articleCsvFile,2000, ";")) !== false) {
            if (!$firstLine)
                Article::create([
                    "name" => $data["1"],
                    "price" => (int)$data["2"],
                    "description" => $data["3"],
                    "creator_id" => $data["4"],
                    // avoiding datetime field overflow error
                    // convert date in csv from string to timestamp type
                    // then continue convert from timestamp to date type
                    "created_at" => date("Y.m.d H:i",
                        \DateTime::createFromFormat("j.n.y H:i", $data[5])->getTimestamp())
                ]);
            $firstLine = false;
        }
        fclose($articleCsvFile);


        // importing articlecategory.csv
        $firstLine = true;
        while (($data = fgetcsv($categoryCsvFile,1000, ";")) !== false) {
            if (!$firstLine) {
                if ($data["2"] == "NULL")
                    Category::create([
                        "name" => $data["1"]
                    ]);
                else
                    Category::create([
                        "name" => $data["1"],
                        "parent" => $data["2"]
                    ]);
            }
            $firstLine = false;
        }
        fclose($categoryCsvFile);
    }
}
