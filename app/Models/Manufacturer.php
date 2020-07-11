<?php

namespace App\Models;

/**
 * @property int $id
 * @property string $name
 * @property string|null $preview
 * @property string|null $description
 * */
class Manufacturer extends BaseModel
{
    const TABLE = "manufacturers";

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
