<?php

namespace Database\Seeders;

use Domain\Orders\Models\OrderStatus;
use Illuminate\Support\Facades\DB;

class OrderStatusesTableSeeder extends BaseSeeder
{
    protected static array $seeds = [
        [
            "id" => OrderStatus::ID_OPEN,
            "name" => "Заказ открыт",
            'color' => null,
        ],
        [
            "id" => OrderStatus::ID_HELEN_CALLED,
            "name" => "Покупателю позвонила или написала Лена",
            'color' => '#ffcc00',
        ],
        [
            "id" => OrderStatus::ID_ALEX_CALLED,
            "name" => "Покупателю позвонил или написал Саша",
            'color' => '#ffcc00',
        ],
        [
            "id" => OrderStatus::ID_NASTYA_CALLED,
            "name" => "Покупателю позвонила или написала Настя",
            'color' => '#ffcc00',
        ],
        [
            "id" => OrderStatus::ID_HELEN_AGREED_WITH_SUPPLIER,
            "name" => "Лена согласовала с поставщиком",
            'color' => '#00ccff',
        ],
        [
            "id" => OrderStatus::ID_ALEX_AGREED_WITH_SUPPLIER,
            "name" => "Саша согласовал с поставщиком",
            'color' => '#00ccff',
        ],
        [
            "id" => OrderStatus::ID_EGOR_AGREED_WITH_SUPPLIER,
            "name" => "Настя согласовала с поставщиком",
            'color' => '#00ccff',
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_CASH,
            "name" => "Подтверждён покупателем - оплата наличными",
            'color' => '#00ccff',
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_ACQUIRING_NO_COMMISSION,
            "name" => "Подтверждён покупателем - оплата картой без комиссии",
            'color' => '#00ccff',
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_ACQUIRING_COMMISSION,
            "name" => "Подтверждён покупателем - оплата картой с комиссией",
            'color' => '#00ccff',
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_CASHLESS,
            "name" => "Подтверждён покупателем - Б/Н",
            'color' => '#00ccff',
        ],
        [
            "id" => OrderStatus::ID_PAYED_DELIVERY,
            "name" => "Заказ оплачен - доставка",
            'color' => '#00ff33',
        ],
        [
            "id" => OrderStatus::ID_PAYED_PICKUP,
            "name" => "Заказ оплачен - самовывоз",
            'color' => '#00ff33',
        ],
        [
            "id" => OrderStatus::ID_IN_OFFICE,
            "name" => "Заказ в офисе",
            'color' => '#33c38f',
        ],
        [
            "id" => OrderStatus::ID_DELIVERED,
            "name" => "Заказ доставлен",
            'color' => null,
        ],
        [
            "id" => OrderStatus::ID_DELAYED,
            "name" => "Отложен",
            'color' => '#ff9900',
        ],
        [
            "id" => OrderStatus::ID_CANCELED_BY_CUSTOMER,
            "name" => "Отменён заказчиком",
            'color' => '#ff0000',
        ],
        [
            "id" => OrderStatus::ID_CANCELED_BY_US,
            "name" => "Отменён нами",
            'color' => '#ff0000',
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
        OrderStatus::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        OrderStatus::query()->insert(static::$seeds);
    }
}
