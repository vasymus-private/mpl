<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see Builder::create()
 * @method static static create()
 *
 * @see Builder::forceCreate()
 * @method static static forceCreate()
 *
 * @see Builder::firstOrCreate()
 * @method static static firstOrCreate()
 *
 * @see Builder::firstOrNew()
 * @method static static firstOrNew()
 * */
abstract class BaseModel extends Model
{
    use CommonTraits;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = "mysql";
}
