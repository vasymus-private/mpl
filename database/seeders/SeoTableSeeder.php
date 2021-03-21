<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Domain\Seo\Models\Seo;

class SeoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Seo::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Seo::query()->insert([
            "id" => Seo::ID_APP,
            "title" => config('app.name'),
            "keywords" => "Паркетные работы в Москве, укладка паркета, ремонт и циклевка паркета, тонирование паркета маслом",
            "description" => "Качественные паркетные работы, гарантия на работу до 5 лет.",
        ]);
    }
}