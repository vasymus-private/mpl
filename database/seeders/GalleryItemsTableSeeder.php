<?php

namespace Database\Seeders;

use Domain\GalleryItems\Models\GalleryItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;

class GalleryItemsTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!$this->shouldClearData()) {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        GalleryItem::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rawSeeds = json_decode(Storage::get("seeds/photos/seeds.json"), true);

        foreach ($rawSeeds as $rawSeed) {
            $asIsAttributes = ["id", "name", "slug", "description", "ordering"];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                $seed[$attribute] = $rawSeed[$attribute];
            }
            $parentGallery = GalleryItem::forceCreate($seed);

            $this->addMedia($parentGallery, $rawSeed["mainImage"]["src"], $rawSeed["mainImage"]["name"], GalleryItem::MC_MAIN_IMAGE);

            foreach ($rawSeed['subPhotos'] as $rawSubSeed) {
                $asIsAttributes = ["id", "name", "slug", "description", "ordering"];
                $subSeed = [];
                foreach ($asIsAttributes as $attribute) {
                    $subSeed[$attribute] = $rawSubSeed[$attribute];
                }
                $subSeed["parent_id"] = $parentGallery->id;
                $childGallery = GalleryItem::forceCreate($subSeed);
                $this->addMedia($childGallery, $rawSubSeed["mainImage"]["src"], $rawSubSeed["mainImage"]["name"], GalleryItem::MC_MAIN_IMAGE);
            }
        }
    }

    /**
     * @param HasMedia|Model $model
     * @param string $src
     * @param string $name
     * @param string $collectionName
     *
     * @return void
     */
    protected function addMedia(HasMedia $model, string $src, string $name, string $collectionName)
    {
        $model
            ->addMedia(storage_path("app/$src"))
            ->preservingOriginal()
            ->usingName($name)
            ->sanitizingFileName(function($fileName) {
                return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
            })
            ->toMediaCollection($collectionName)
        ;
    }
}
