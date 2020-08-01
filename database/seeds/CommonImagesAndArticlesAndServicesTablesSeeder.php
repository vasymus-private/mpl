<?php

use App\Models\Admin;
use App\Models\Article;
use App\Models\Seo;
use App\Models\Service;
use Illuminate\Database\Seeder;
use App\Models\ServicesGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class CommonImagesAndArticlesAndServicesTablesSeeder extends Seeder
{
    protected $oldNewImagesSrc = [];

    protected $seeds = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Service::query()->truncate();
        Article::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->seeds = json_decode(Storage::get("seeds/pages/seeds.json"), true);

        $this->seedCommonImages();
        $this->updateHtmlToViews();
        $this->seedArticlesAndServices();
    }

    protected function seedCommonImages()
    {
        /** @var Admin $admin */
        $admin = Admin::query()->findOrFail(Admin::ID_CENTRAL_ADMIN);

        foreach ($this->seeds as $seed) {
            $images = $seed["images"];
            foreach ($images as $image) {
                $media = $admin
                            ->addMedia(storage_path("app/$image"))
                            ->preservingOriginal()
                            ->toMediaCollection(Admin::MC_COMMON_MEDIA)
                ;
                $url = $media->getUrl();
                $this->oldNewImagesSrc[$image] = $url;
            }
        }
    }

    protected function updateHtmlToViews()
    {
        foreach ($this->seeds as $seed) {
            $htmlPath = $seed["html"];
            $html = Storage::get($htmlPath);

            $crawler = new Crawler($html);
            $crawler->filter("img")->each(function(Crawler $node) {
                $oldSrc = $node->attr("src");
                $newSrc = $this->oldNewImagesSrc[$oldSrc];
                $node->getNode(0)->setAttribute("src", $newSrc);
            });

            $newHtml = str_replace(
                ["<body>", "</body>", "http://parket-lux.ru", "http://www.parket-lux.ru"],
                "",
                $crawler->html())
            ;

            $folder = $seed["is_article"] ? "articles" : "services";
            $name = basename($htmlPath);
            $path = "seeds/pages/final/$folder/$name";
            Storage::put($path, $newHtml);
        }
    }

    protected function seedArticlesAndServices()
    {
        foreach ($this->seeds as $seed) {
            $isArticle = $seed["is_article"];

            $attr = [
                "name" => $seed["name"],
                "slug" => $seed["slug"],
                "is_active" => $seed["is_active"],
            ];

            /** @var Article|Service $model */
            if ($isArticle) {
                $model = Article::forceCreate($attr);
                $oldUrlArr = explode("/", trim($seed["_oldUrl"], "\\/"));
                $isParent = count($oldUrlArr) === 2;

                if (!$isParent) {
                    $parentSlug = $oldUrlArr[1];
                    /** @var Article $parent */
                    $parent = Article::query()->where(Article::TABLE . ".slug", $parentSlug)->firstOrFail();
                    $model->parent_id = $parent->id;
                    $model->save();
                }
            } else {
                switch (true) {
                    case in_array($seed["slug"], ["ukladka-shtuchnogo-parketa", "ukladka-massivnoy-doski", "ukladka-parketnoy-doski", "ukladka-laminata", "plintus-i-porozhki"]) : {
                        $serviceGroupId = ServicesGroup::ID_PARQUET_LAYING;
                        break;
                    }
                    case in_array($seed["slug"], ["tsiklevka-parketa", "remont-parketa", "ukhod-za-parketom", "tonirovanie-parketa", "parketnaya-khimiya", "parketnoe-oborudovanie"]) : {
                        $serviceGroupId = ServicesGroup::ID_PARQUET_RESTORATION;
                        break;
                    }
                    case in_array($seed["slug"], ["pol-na-lagakh", "styazhka-pola", "sukhaya-styazhka-knauf"]) : {
                        $serviceGroupId = ServicesGroup::ID_FOUNDATION_PREPARE;
                        break;
                    }
                    default : {
                        throw new \LogicException("Cann't find appropriate service group");
                    }
                }
                $attr["group_id"] = $serviceGroupId;
                $model = Service::forceCreate($attr);
            }

            $seo = $seed["seo"];
            $seoModel = new Seo([
                "title" => $seo["title"],
                "h1" => $seo["h1"],
                "keywords" => $seo["keywords"],
                "description" => $seo["description"],
            ]);

            $model->seo()->save($seoModel);
        }
    }
}
