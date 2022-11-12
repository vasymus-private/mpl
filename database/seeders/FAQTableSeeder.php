<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Domain\FAQs\Models\FAQ;
use Domain\Users\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class FAQTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (FAQ::query()->count() !== 0 && ! $this->shouldClearData()) {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FAQ::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rawSeeds = json_decode(Storage::get("seeds/faq/new/seeds.json"), true);
        $seeds = [];

        foreach ($rawSeeds as $rawSeed) {
            $asIsAttributes = ["id", "name", "slug", "parent_id"];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                $seed[$attribute] = $rawSeed[$attribute];
            }
            $name = $seed["name"];
            $slug = $seed["slug"];
            if (empty($slug)) {
                $seed["slug"] = Str::slug($name);
            }
            $seed["created_at"] = $rawSeed["created_at"]
                ? Carbon::createFromFormat("d.m.Y", $rawSeed["created_at"])
                : null
            ;

            $seed["question"] = $this->storeImageAndUpdateHtml($rawSeed["question"]);
            $seed["answer"] = $this->storeImageAndUpdateHtml($rawSeed["answer"]);

            $seeds[] = $seed;
        }

        FAQ::query()->insert($seeds);
    }

    protected function storeImageAndUpdateHtml(string $html): string
    {
        $crawler = new Crawler($html);
        $crawler->filter("img")->each(function (Crawler $imgNode) {
            $attr = $imgNode->attr("src");

            $admin = Admin::getCentralAdmin();
            $media = $admin
                ->addMedia(storage_path("app/$attr"))
                ->preservingOriginal()
                ->toMediaCollection(Admin::MC_COMMON_MEDIA)
            ;
            $url = $media->getUrl();

            /** @var \DOMElement $domElement */
            $domElement = $imgNode->getNode(0);
            $domElement->setAttribute("src", $url);
        });

        return str_replace(["<body>", "</body>"], "", $crawler->html());
    }

    public function runOld()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FAQ::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rawSeeds = json_decode(Storage::get("seeds/faq/old/seeds.json"), true);
        $seeds = [];

        foreach ($rawSeeds as $rawSeed) {
            $asIsAttributes = ["id", "question", "answer", "is_active", "user_email", "user_name"];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                $seed[$attribute] = $rawSeed[$attribute];
            }
            $seed["created_at"] = $rawSeed["created_at"]
                ? Carbon::createFromFormat("d.m.Y H:i:s", $rawSeed["created_at"])
                : null
            ;
            $seeds[] = $seed;
        }

        FAQ::query()->insert($seeds);
    }
}
