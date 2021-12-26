<?php
/**
 * @var \Domain\Products\DTOs\Admin\OrderAdditionalProductItemDTO|array $product
 */
?>
<tr wire:key="additional-product-item-{{$product['uuid']}}">
    <td>
        <span class="main-grid-cell-content">{{$product['displayId']}}</span>
    </td>
    <td>
        <span class="main-grid-cell-content">{{$product['is_active'] ? 'Да' : 'Нет'}}</span>
    </td>
    <td>
        <div class="text-center"><a target="_blank" href="{{$product['route_link']}}"><img class="img-fluid" src="{{$product['image']}}" alt="" /></a></div>
    </td>
    <td>
        <span class="main-grid-cell-content"><a target="_blank" href="{{$product['route_link']}}">{{$product['name']}}</a></span>
    </td>
    <td>
        <span class="main-grid-cell-content">
            @if($product['is_variation'] || empty($product['variations']))
                <button class="btn btn-link" wire:click="addProductItemToOrder('{{$product['uuid']}}')" type="button">Выбрать</button>
            @else
                <button class="btn btn-link" wire:click="toggleShowVariations('{{$product['uuid']}}')" type="button">{{$product['showVariations'] ? 'Свернуть' : 'Развернуть'}}</button>
            @endif
        </span>
    </td>
    <td><span class="main-grid-cell-content">{{$product['price_retail_formatted']}}</span></td>
</tr>
