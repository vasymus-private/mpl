<?php

namespace Database\Seeders;

use Domain\Orders\Models\BillStatus;
use Illuminate\Support\Facades\DB;

class BillStatusesTableSeeder extends BaseSeeder
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BillStatus::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        BillStatus::query()->insert(static::$seeds);
    }
}
