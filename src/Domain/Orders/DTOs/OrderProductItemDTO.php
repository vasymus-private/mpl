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
     * @deprecated For backward compatibility. Should be the copy as $count
     *
     * @var int
     */
    public int $order_product_count = 1;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $unit;

    /**
     * @var int|null
     */
    public ?int $ordering;

    /**
     * @var float|int
     */
    public $price_retail_rub;

    /**
     * @deprecated For backward compatibility. Should be the copy as $price_retail_rub
     *
     * @var float|int
     */
    public $order_product_price_retail_rub;

    /**
     * @var bool|null
     */
    public ?bool $price_retail_rub_was_updated = false;

    /**
     * @deprecated For backward compatibility. Should be the copy as $price_retail_rub_was_updated
     *
     * @var bool|null
     */
    public ?bool $order_product_price_retail_rub_was_updated = false;

    /**
     * @var float|int|null
     */
    public $price_retail_rub_origin;

    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $product;

    /**
     * @deprecated For backward compatibility. Should be used $product->id
     *
     * @var int
     */
    public int $id;
}
