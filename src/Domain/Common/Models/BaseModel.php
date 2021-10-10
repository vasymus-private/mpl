<?php

namespace Domain\Common\Models;

use Domain\Common\Models\CommonTraits;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see Builder::create()
 * @method static static create(array $attributes = [])
 *
 * @see Builder::forceCreate()
 * @method static static forceCreate(array $attributes)
 *
 * @see Builder::firstOrCreate()
 * @method static static firstOrCreate(array $attributes = [], array $values = [])
 *
 * @see Builder::firstOrNew()
 * @method static static firstOrNew(array $attributes = [], array $values = [])
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
