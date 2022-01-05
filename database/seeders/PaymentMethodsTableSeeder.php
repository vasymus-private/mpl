<?php

namespace Database\Seeders;

use Domain\Orders\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    protected static $seeds = [
        [
            'id' => PaymentMethod::ID_BANK_CARD,
            'name' => 'Банковской картой',
            'description' => "Ваш заказ формируют на складе. По готовности, на Ваш email придет письмо с инструкцией и ссылкой на страницу банка для оплаты картой.",
            'describable' => false,
        ],
        [
            'id' => PaymentMethod::ID_CASH,
            'name' => 'Наличными',
            'description' => "Оплата наличными экспедитору при получении.",
            'describable' => false,
        ],
        [
            'id' => PaymentMethod::ID_CASHLESS_FROM_ACCOUNT,
            'name' => 'Безналичная оплата со счёта юридического лица',
            'description' => "Для оформления счета потребуются реквизиты организации. С вами свяжутся по email или телефону.",
            'describable' => true,
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
        PaymentMethod::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        PaymentMethod::query()->insert(static::$seeds);
    }
}
