<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * */
class AvailabilityStatus extends BaseModel
{
    const TABLE = "availability_statuses";

    const ID_AVAILABLE_IN_STOCK = 1;
    const ID_AVAILABLE_NOT_IN_STOCK = 2;
    const ID_NOT_AVAILABLE = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
