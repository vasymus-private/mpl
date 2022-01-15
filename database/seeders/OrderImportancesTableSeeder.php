<?php

namespace Database\Seeders;

use Domain\Orders\Models\OrderImportance;
use Illuminate\Support\Facades\DB;

class OrderImportancesTableSeeder extends BaseSeeder
{
    protected static array $seeds = [
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
            "color" => "rgba(247, 6, 6, 0.52)",
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
