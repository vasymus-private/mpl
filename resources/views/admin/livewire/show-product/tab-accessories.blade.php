<?php
/**
 * @var array[][] $productProducts @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
 * @var array[] $categories @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category}
 * @var array[][] $loadedForProductProduct @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
 */
?>
<div class="item-edit product-edit">
@include(
    'admin.livewire.show-product.related',
    [
        'type' => \Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY,
        'wire_field' => 'accessory_name',
        'title' => 'Аксессуары',
        'productProducts' => $productProducts,
        'categories' => $categories,
        'loadedForProductProduct' => $loadedForProductProduct,
    ]
)
</div>
