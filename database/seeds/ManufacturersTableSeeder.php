<?php

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturersTableSeeder extends Seeder
{
    protected static $seeds = [
        [

        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manufacturer::query()->truncate();

        Manufacturer::query()->insert(static::$seeds);
    }
}
