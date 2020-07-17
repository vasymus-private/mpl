<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string|null $ip
 * @property string|null $email
 * @property Carbon|null $created_at
 * */
class Blacklist extends BaseModel
{
    use SoftDeletes;

    const TABLE = "blacklist";
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
