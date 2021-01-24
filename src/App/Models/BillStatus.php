<?php

namespace App\Models;

/**
 * @property int $id
 * @property string $name
 * */
class BillStatus extends BaseModel
{
    const TABLE = "bill_statuses";

    const ID_NOT_BILLED = 1;
    const ID_BILLED = 2;
    const ID_PAYED = 3;

    const DEFAULT_ID = self::ID_NOT_BILLED;

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
