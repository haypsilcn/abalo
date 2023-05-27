<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // delete all records in table if exists
        DB::table("article_has_category")->truncate();

        $articleHasCategoryCSV = fopen(base_path("database/data/csv/article_has_articlecategory.csv"), "r");

        // importing
        $firstLine = true;
        while (($data = fgetcsv($articleHasCategoryCSV,1000, ";")) !== false) {
            if (!$firstLine)
                DB::table("article_has_category")->insert([
                    "category_id" => $data["0"],
                    "article_id" => $data["1"],
                ]);
            $firstLine = false;
        }
        fclose($articleHasCategoryCSV);
    }
}
