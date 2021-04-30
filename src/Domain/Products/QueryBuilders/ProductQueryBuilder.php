<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    /**
     * @var string
     */
    protected string $table = Product::TABLE;

    public function active(): self
    {
        return $this->where("{$this->table}.is_active", true);
    }

    public function available(): self
    {
        return $this->whereIn("{$this->table}.availability_status_id", [AvailabilityStatus::ID_AVAILABLE_IN_STOCK, AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK]);
    }

    public function notVariations(): self
    {
        return $this->whereNull("{$this->table}.parent_id");
    }

    public function variations(): self
    {
        return $this->whereNotNull("{$this->table}.parent_id");
    }

    public function doesntHaveVariations(): self
    {
        return $this->doesntHave("variations");
    }
}
