<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string|null $color
 * */
class OrderStatus extends BaseModel
{
    const TABLE = "order_statuses";

    const ID_OPEN = 1;
    const ID_HELEN_CALLED = 2; // todo temporary decision
    const ID_ALEX_CALLED = 3; // todo temporary decision
    const ID_NASTYA_CALLED = 4; // todo temporary decision
    const ID_HELEN_AGREED_WITH_SUPPLIER = 5; // todo temporary decision
    const ID_ALEX_AGREED_WITH_SUPPLIER = 6; // todo temporary decision
    const ID_EGOR_AGREED_WITH_SUPPLIER = 7; // todo temporary decision
    const ID_CUSTOMER_CONFIRMED_CASH = 8;
    const ID_CUSTOMER_CONFIRMED_ACQUIRING_NO_COMMISSION = 9;
    const ID_CUSTOMER_CONFIRMED_ACQUIRING_COMMISSION = 10;
    const ID_CUSTOMER_CONFIRMED_CASHLESS = 11;
    const ID_PAYED_DELIVERY = 12;
    const ID_PAYED_PICKUP = 13;
    const ID_IN_OFFICE = 14;
    const ID_DELIVERED = 15;
    const ID_DELAYED = 16;
    const ID_CANCELED_BY_CUSTOMER = 17;
    const ID_CANCELED_BY_US = 18;

    const IDS_OPEN = [
        self::ID_OPEN,
        self::ID_HELEN_CALLED,
        self::ID_ALEX_CALLED,
        self::ID_NASTYA_CALLED,
        self::ID_HELEN_AGREED_WITH_SUPPLIER,
        self::ID_ALEX_AGREED_WITH_SUPPLIER,
        self::ID_EGOR_AGREED_WITH_SUPPLIER,
        self::ID_CUSTOMER_CONFIRMED_CASH,
        self::ID_CUSTOMER_CONFIRMED_ACQUIRING_NO_COMMISSION,
        self::ID_CUSTOMER_CONFIRMED_ACQUIRING_COMMISSION,
        self::ID_CUSTOMER_CONFIRMED_CASHLESS,
    ];
    const IDS_PAYED = [
        self::ID_PAYED_DELIVERY,
        self::ID_PAYED_PICKUP,
        self::ID_IN_OFFICE,
        self::ID_IN_OFFICE,
        self::ID_DELIVERED
    ];
    const IDS_CLOSED = [
        self::ID_DELAYED,
        self::ID_CANCELED_BY_CUSTOMER,
        self::ID_CANCELED_BY_US,
    ];

    const DEFAULT_ID = self::ID_OPEN;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
