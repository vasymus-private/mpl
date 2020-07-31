<?php

namespace App\Models;

/**
 * @property int $id
 * @property string $name
 * @property int $ordering
 * */
class ServicesGroup extends BaseModel
{
    const TABLE = "services_groups";

    const ID_PARQUET_LAYING = 1;
    const ID_PARQUET_RESTORATION = 2;
    const ID_FOUNDATION_PREPARE = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
