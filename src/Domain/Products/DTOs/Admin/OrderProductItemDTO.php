<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Common\Models\Currency;
use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;
use Support\H;

class OrderProductItemDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $uuid;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var int
     */
    public int $order_product_count;

    /**
     * @var string|null
     */
    public ?string $price_purchase_rub_formatted;

    /**
     * @var float|int|null
     */
    public $price_purchase_rub_sum;

    /**
     * @var string|null
     */
    public ?string $price_purchase_rub_sum_formatted;

    /**
     * @var float|int|null
     */
    public $price_retail_rub;

    /**
     * @var string
     */
    public string $price_retail_rub_formatted;

    /**
     * @var float|int|null
     */
    public $price_retail_rub_sum;

    /**
     * @var string
     */
    public string $price_retail_rub_sum_formatted;

    /**
     * @var string
     */
    public string $price_retail_purchase_sum_diff_rub_formatted;

    /**
     * @var string|null
     */
    public ?string $unit;

    /**
     * @var float|int|string|null
     */
    public $coefficient;

    /**
     * @var string|null
     */
    public ?string $availability_status_name;

    /**
     * @var string|null
     */
    public ?string $image;

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return self
     */
    public static function fromOrderProductItem(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'uuid' => $product->uuid,
            'name' => $product->name,
            'order_product_count' => $product->order_product_count,
            'price_purchase_rub_formatted' => $product->price_purchase_rub_formatted,
            'price_purchase_rub_sum' => $product->order_product_price_purchase_sum,
            'price_purchase_rub_sum_formatted' => $product->order_product_price_purchase_sum_formatted,
            'price_retail_rub' => $product->order_product_price_retail_rub,
            'price_retail_rub_formatted' => $product->order_product_price_retail_rub_formatted,
            'price_retail_rub_sum' => $product->order_product_price_retail_rub_sum,
            'price_retail_rub_sum_formatted' => $product->order_product_price_retail_rub_sum_formatted,
            'price_retail_purchase_sum_diff_rub_formatted' => H::priceRubFormatted($product->order_product_price_retail_rub_sum - $product->order_product_price_purchase_sum, Currency::ID_RUB),
            'unit' => $product->unit,
            'coefficient' => $product->coefficient,
            'availability_status_name' => $product->availability_status_name,
            'image' => $product->main_image_sm_thumb_url,
        ]);
    }
}
