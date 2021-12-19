<?php

namespace Domain\Orders\DTOs;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderProductItemDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $count = 1;

    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $product;
}
