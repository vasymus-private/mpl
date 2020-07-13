<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property int $id
 * @property string $question
 * @property string|null $answer
 * @property bool $is_active
 * @property string|null $user_name
 * @property string|null $user_email
 * @property Carbon $created_at
 * */
class FAQ extends BaseModel
{
    const TABLE = "faq";
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "bool",
    ];
}
