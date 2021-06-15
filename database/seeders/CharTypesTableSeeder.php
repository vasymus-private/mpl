<?php

namespace Database\Seeders;

use Domain\Products\Models\CharType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharTypesTableSeeder extends Seeder
{
    protected array $seeds = [
        [
            'id' => CharType::ID_TEXT,
            'name' => CharType::NAME_TEXT
        ],
        [
            'id' => CharType::ID_RATE,
            'name' => CharType::NAME_RATE,
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
        CharType::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        CharType::query()->insert($this->seeds);
    }
}
