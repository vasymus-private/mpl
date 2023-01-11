<?php

namespace Database\Seeders;

use Domain\Seo\Models\Seo;
use Illuminate\Support\Facades\DB;

class SeoTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedAppSeo();

        if (Seo::query()->count() !== 0 && ! $this->shouldClearData()) {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Seo::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->seedAppSeo();
    }

    protected function seedAppSeo()
    {
        /** @var \Domain\Seo\Models\Seo $seo */
        $seo = Seo::query()->find(Seo::ID_APP) ?? new Seo();
        $seo->title = config('app.name');
        $seo->keywords = "Паркетные работы в Москве, укладка паркета, ремонт и циклевка паркета, тонирование паркета маслом";
        $seo->description = "Качественные паркетные работы, гарантия на работу до 5 лет.";
        $seo->save();
    }
}
