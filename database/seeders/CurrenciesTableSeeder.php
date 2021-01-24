<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    protected static $seeds = [
        [
            'id' => Currency::ID_RUB,
            'name' => 'RUB',
        ],
        [
            'id' => Currency::ID_EUR,
            'name' => 'EUR',
        ],
        [
            'id' => Currency::ID_USD,
            'name' => 'USD',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Currency::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Currency::query()->insert(static::$seeds);
    }
}
