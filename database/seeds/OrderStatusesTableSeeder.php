<?php

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusesTableSeeder extends Seeder
{
    protected static $seeds = [
        [
            "id" => OrderStatus::ID_OPEN,
            "name" => "Заказ открыт",
        ],
        [
            "id" => OrderStatus::ID_HELEN_CALLED,
            "name" => "Покупателю позвонила или написала Лена",
        ],
        [
            "id" => OrderStatus::ID_ALEX_CALLED,
            "name" => "Покупателю позвонил или написал Саша",
        ],
        [
            "id" => OrderStatus::ID_EGOR_CALLED,
            "name" => "Покупателю позвонил или написал Егор",
        ],
        [
            "id" => OrderStatus::ID_HELEN_AGREED_WITH_SUPPLIER,
            "name" => "Лена согласовала с поставщиком",
        ],
        [
            "id" => OrderStatus::ID_ALEX_AGREED_WITH_SUPPLIER,
            "name" => "Саша согласовал с поставщиком",
        ],
        [
            "id" => OrderStatus::ID_EGOR_AGREED_WITH_SUPPLIER,
            "name" => "Егор согласовал с поставщиком",
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_CASH,
            "name" => "Подтверждён покупателем - оплата наличными",
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_ACQUIRING_NO_COMMISSION,
            "name" => "Подтверждён покупателем - оплата картой без комиссии",
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_ACQUIRING_COMMISSION,
            "name" => "Подтверждён покупателем - оплата картой с комиссией",
        ],
        [
            "id" => OrderStatus::ID_CUSTOMER_CONFIRMED_CASHLESS,
            "name" => "Подтверждён покупателем - Б/Н",
        ],
        [
            "id" => OrderStatus::ID_PAYED_DELIVERY,
            "name" => "Заказ оплачен - доставка",
        ],
        [
            "id" => OrderStatus::ID_PAYED_PICKUP,
            "name" => "Заказ оплачен - самовывоз",
        ],
        [
            "id" => OrderStatus::ID_IN_OFFICE,
            "name" => "Заказ в офисе",
        ],
        [
            "id" => OrderStatus::ID_DELIVERED,
            "name" => "Заказ доставлен",
        ],
        [
            "id" => OrderStatus::ID_DELAYED,
            "name" => "Отложен",
        ],
        [
            "id" => OrderStatus::ID_CANCELED_BY_CUSTOMER,
            "name" => "Отменён заказчиком",
        ],
        [
            "id" => OrderStatus::ID_CANCELED_BY_US,
            "name" => "Отменён нами",
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
        OrderStatus::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        OrderStatus::query()->insert(static::$seeds);
    }
}
