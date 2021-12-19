<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderProductItemDTO extends DataTransferObject
{
    public int $id;

    public string $uuid;

    public string $name;

    public int $order_product_count;

    public ?string $price_purchase_rub_formatted;

    public ?string $unit;

    /**
     * @var float|int|string|null
     */
    public $coefficient;

    public ?string $availability_status_name;

    public ?string $image;

    public $price_retail_rub;

    public static function fromOrderProductItem(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'uuid' => $product->uuid,
            'name' => $product->name,
            'order_product_count' => $product->order_product_count,
            'price_purchase_rub_formatted' => $product->price_purchase_rub_formatted,
            'unit' => $product->unit,
            'coefficient' => $product->coefficient,
            'availability_status_name' => $product->availability_status_name,
            'image' => $product->main_image_sm_thumb_url,
            'price_retail_rub' => 0, // todo
        ]);
    }
}
