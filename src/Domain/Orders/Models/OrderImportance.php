<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * */
class OrderImportance extends BaseModel
{
    const TABLE = "order_importances";

    const ID_GREY = 1;
    const ID_ORANGE = 2;
    const ID_RED = 3;

    const DEFAULT_ID = self::ID_GREY;

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
