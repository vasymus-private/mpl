<?php

namespace Database\Seeders;

use Domain\Products\Models\AvailabilityStatus;
use Illuminate\Support\Facades\DB;

class AvailabilityStatusesTableSeeder extends BaseSeeder
{
    protected static array $seeds = [
        [
            'id' => AvailabilityStatus::ID_AVAILABLE_IN_STOCK,
            'name' => 'В наличии на складе',
        ],
        [
            'id' => AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK,
            'name' => 'В наличии на заказ',
        ],
        [
            'id' => AvailabilityStatus::ID_NOT_AVAILABLE,
            'name' => 'Отсутствует',
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
        AvailabilityStatus::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        AvailabilityStatus::query()->insert(static::$seeds);
    }
}
