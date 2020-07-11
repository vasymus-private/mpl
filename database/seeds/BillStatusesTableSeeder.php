<?php

use App\Models\BillStatus;
use Illuminate\Database\Seeder;

class BillStatusesTableSeeder extends Seeder
{
    protected static $seeds = [
        [
            'id' => BillStatus::ID_NOT_BILLED,
            'name' => 'не выставлен',
        ],
        [
            'id' => BillStatus::ID_BILLED,
            'name' => 'выставлен',
        ],
        [
            'id' => BillStatus::ID_PAYED,
            'name' => 'оплачен',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillStatus::query()->truncate();

        BillStatus::query()->insert(static::$seeds);
    }
}
