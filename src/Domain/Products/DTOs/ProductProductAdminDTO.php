<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ProductProductAdminDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    public string $url;

    public string $image;

    public string $price_rub_formatted;

    public bool $toDelete = false;

    public bool $isSelected = false;

    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'name' => $product->name,
            'url' => route("admin.products.edit", $product->id),
            'image' => $product->getFirstMediaUrl(Product::MC_MAIN_IMAGE),
            'price_rub_formatted' => $product->price_retail_rub_formatted,
        ]);
    }
}
