<?php

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ManufacturersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Manufacturer::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $seedsRaw = json_decode(Storage::get("seeds/manufacturers/seeds.json"), true);

        foreach ($seedsRaw as $seedRaw) {
            $asIsAttributes = ["id", "name", "preview", "description", "ordering"];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                $seed[$attribute] = $seedRaw[$attribute];
            }
            $seed["slug"] = $seed["name"];
            $manufacturer = Manufacturer::forceCreate($seed);

            if (empty($seedRaw["image"])) continue;
            if (!Storage::exists($seedRaw["image"])) continue;

            $manufacturer
                ->addMedia(storage_path("app/$seedRaw[image]"))
                ->preservingOriginal()
                ->toMediaCollection(Manufacturer::MC_MAIN_IMAGE)
            ;
        }
    }
}
