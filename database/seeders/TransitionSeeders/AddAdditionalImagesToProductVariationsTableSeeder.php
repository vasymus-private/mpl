<?php

namespace Database\Seeders\TransitionSeeders;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Seeder;

class AddAdditionalImagesToProductVariationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedOne();

        $this->seedTwo();
    }

    protected function seedOne()
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = Product::query()->where("name", "Алюминиевый плинтус Profilpas - 90")->first();

        if (!$product) return;

        $product->variations->each(function(Product $variation) {
//            dump($variation->id);
            $variation
                ->addMedia(storage_path("app/seeds/for-transition-seeders/1.jpg"))
                ->preservingOriginal()
                ->toMediaCollection(Product::MC_ADDITIONAL_IMAGES)
            ;
        });
    }

    protected function seedTwo()
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = Product::query()->where("name", "Запасные детали для Lagler Trio")->first();

        if (!$product) return;

        $product->variations->each(function(Product $variation) {
//            dump($variation->id);
            $variation
                ->addMedia(storage_path("app/seeds/for-transition-seeders/2.png"))
                ->preservingOriginal()
                ->toMediaCollection(Product::MC_ADDITIONAL_IMAGES)
            ;
        });
    }
}
