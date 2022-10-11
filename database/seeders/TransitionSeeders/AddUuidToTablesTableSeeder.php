<?php

namespace Database\Seeders\TransitionSeeders;

use Database\Seeders\BaseSeeder;
use Domain\Articles\Models\Article;
use Domain\FAQs\Models\FAQ;
use Domain\GalleryItems\Models\GalleryItem;
use Domain\Orders\Models\Order;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
use Domain\Products\Models\InformationalPrice;
use Domain\Services\Models\Service;
use Domain\Users\Models\BaseUser\BaseUser;
use Domain\Users\Models\Blacklist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AddUuidToTablesTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cb = function (Collection $models) {
            $models->each(function (Model $model) {
                /** @var \Domain\Orders\Models\Order|\Domain\Products\Models\Brand|\Domain\Products\Models\Category $model */

                $model->uuid = (string)Str::uuid();
                $model->save();
            });
        };

        Order::query()->whereNull('uuid')->chunk(300, $cb);

        Brand::query()->whereNull('uuid')->chunk(300, $cb);

        Category::query()->whereNull('uuid')->chunk(300, $cb);

        Article::query()->whereNull('uuid')->chunk(300, $cb);

        Blacklist::query()->whereNull('uuid')->chunk(300, $cb);

        Char::query()->whereNull('uuid')->chunk(300, $cb);

        CharCategory::query()->whereNull('uuid')->chunk(300, $cb);

        FAQ::query()->whereNull('uuid')->chunk(300, $cb);

        GalleryItem::query()->whereNull('uuid')->chunk(300, $cb);

        InformationalPrice::query()->whereNull('uuid')->chunk(300, $cb);

        Service::query()->whereNull('uuid')->chunk(300, $cb);

        BaseUser::query()->whereNull('uuid')->chunk(300, $cb);
    }
}
