<?php

namespace Database\Seeders;

use Domain\Orders\Models\OrderImportance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderImportancesTableSeeder extends Seeder
{
    protected static $seeds = [
        [
            "id" => OrderImportance::ID_GREY,
            "name" => "серый",
            "color" => "#eeeeee",
        ],
        [
            "id" => OrderImportance::ID_YELLOW,
            "name" => "желтый",
            "color" => "#ffff00",
        ],
        [
            "id" => OrderImportance::ID_RED,
            "name" => "красный",
            "color" => "#ff0000",
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrderImportance::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        OrderImportance::query()->insert(static::$seeds);
    }
}
