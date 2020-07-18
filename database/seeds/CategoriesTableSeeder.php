<?php

use App\Models\Category;
use App\Models\Seo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rawSeeds = json_decode(Storage::get("seeds/categories/seeds.json"), true);
        foreach ($rawSeeds as $rawSeed) {
            $asIsAttributes = ["id", "name", "slug", "description", "ordering", "is_active", "parent_id"];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                $seed[$attribute] = $rawSeed[$attribute];
            }
            $category = Category::forceCreate($seed);
            if (empty($rawSeed["seo_title"]) && empty($rawSeed["seo_keywords"]) && empty($rawSeed["seo_content"])) continue;

            $seo = $category->seo ?: new Seo();

            if (!empty($rawSeed["seo_title"])) {
                $seo->title = $rawSeed["seo_title"];
            }
            if (!empty($rawSeed["seo_keywords"])) {
                $seo->keywords = $rawSeed["seo_keywords"];
            }
            if (!empty($rawSeed["seo_content"])) {
                $seo->description = $rawSeed["seo_content"];
            }

            $category->seo()->save($seo);
        }
    }
}
