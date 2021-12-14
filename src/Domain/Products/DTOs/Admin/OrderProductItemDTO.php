<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderProductItemDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    public int $count;

    public static function fromOrderProductItem(Product $product): self
    {
        return new self([
            'id',
            'name',
            'count',
        ]);
    }
}
