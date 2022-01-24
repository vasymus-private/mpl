<?php

namespace Database\Seeders;

use Domain\Products\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandsTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! $this->shouldClearData()) {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $seedsRaw = json_decode(Storage::get("seeds/manufacturers/seeds.json"), true);

        foreach ($seedsRaw as $seedRaw) {
            $asIsAttributes = ["id", "name", "preview", "description", "ordering"];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                $seed[$attribute] = $seedRaw[$attribute];
            }
            $seed["slug"] = Str::slug($seed["name"]);
            $manufacturer = Brand::forceCreate($seed);

            if (empty($seedRaw["image"])) {
                continue;
            }
            if (! Storage::exists($seedRaw["image"])) {
                continue;
            }

            $manufacturer
                ->addMedia(storage_path("app/$seedRaw[image]"))
                ->preservingOriginal()
                ->toMediaCollection(Brand::MC_MAIN_IMAGE)
            ;
        }
    }
}
