<?php

namespace Domain\Common\Models;

use Domain\Common\Models\CommonTraits;
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
 *
 * @method static static|Builder query()
 * */
abstract class BaseModel extends Model
{
    use CommonTraits;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = "mysql";
}