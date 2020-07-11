<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;

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
        Currency::query()->truncate();

        Currency::query()->insert(static::$seeds);
    }
}
