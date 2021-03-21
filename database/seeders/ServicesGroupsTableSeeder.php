<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Services\Models\ServicesGroup;
use Illuminate\Support\Facades\DB;

class ServicesGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ServicesGroup::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ServicesGroup::query()->insert([
            [
                "id" => ServicesGroup::ID_PARQUET_LAYING,
                "name" => "Укладка паркета",
                "ordering" => 10,
            ],
            [
                "id" => ServicesGroup::ID_PARQUET_RESTORATION,
                "name" => "Восстановление паркета",
                "ordering" => 20,
            ],
            [
                "id" => ServicesGroup::ID_FOUNDATION_PREPARE,
                "name" => "Подготовка основания",
                "ordering" => 30,
            ],
        ]);
    }
}