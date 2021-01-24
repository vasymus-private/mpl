<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $describable
 * */
class PaymentMethod extends BaseModel
{
    const TABLE = "payment_methods";

    const ID_BANK_CARD = 1;
    const ID_CASH = 2;
    const ID_SBERBANK_INVOICE = 3;
    const ID_CASHLESS_FROM_ACCOUNT = 4;

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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'describable' => 'boolean'
    ];
}
