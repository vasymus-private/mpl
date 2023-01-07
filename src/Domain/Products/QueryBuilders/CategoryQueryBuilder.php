<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Models\Category;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Products\Models\Category
 * @extends Builder<TModelClass>
 *
 * @method \Domain\Products\Models\Category|null first($columns = ['*'])
 * @method \Domain\Products\Models\Category findOrFail($id, $columns = ['*'])
 * @method \Illuminate\Database\Eloquent\Collection<\Domain\Products\Models\Category> get($columns = ['*'])
 */
class CategoryQueryBuilder extends Builder
{
    /**
     * @var string
     */
    protected string $table = Category::TABLE;

    public function parents(): self
    {
        return $this->whereNull($this->table . ".parent_id");
    }

    public function active(): self
    {
        return $this->where($this->table . ".is_active", true);
    }

    public function ordering(): self
    {
        return $this->orderBy($this->table . ".ordering");
    }

    public function parquetMaterials(): self
    {
        return $this->where($this->table . '.product_type', Category::PRODUCT_TYPE_PARQUET_MATERIALS);
    }

    public function parquetWorks(): self
    {
        return $this->where($this->table . '.product_type', Category::PRODUCT_TYPE_PARQUET_WORKS);
    }
}
