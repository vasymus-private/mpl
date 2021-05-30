<?php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator|array[] $products @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
 * @var string $currentRoute
 * @var string $newRoute
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 * @var string|int|null $brand_id
 * @var string|int|null $brand_name
 */
?>
<div>
    <form wire:submit.prevent="handleSearch" method="GET">
        <div class="search form-group row">
            <div class="col-xs-12 col-sm-10">
                <div class="input-group mb-3">
                    @if($category_id)
                        <div class="input-group-prepend">
                            <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{$category_name}}</span>
                            <button wire:click.prevent="clearCategoryFilter" class="btn btn-light" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                    @endif
                    @if($brand_id)
                        <div class="input-group-prepend">
                            <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{$brand_name}}</span>
                            <button wire:click.prevent="clearBrandFilter" class="btn btn-light" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                    @endif
                    <input wire:model="search" type="text" class="form-control" placeholder="Фильтр + поиск" aria-label="Фильтр + поиск" aria-describedby="search-button">
                    <div class="input-group-append">
                        <button wire:click.prevent="clearAllFilters" class="btn-outline-secondary" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <button class="btn-outline-secondary search-icon" type="submit" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2">
                <div class="dropdown">
                    <a href="#" wire:click.prevent="newItem" class="btn btn-add btn-secondary">Создать</a>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input class="form-check-input position-static" type="checkbox" id="check-all" aria-label="Check all">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">ID</span></th>
                <th scope="col"><span class="main-grid-head-title">Сортировка</span></th>
                <th scope="col"><span class="main-grid-head-title">Название</span></th>
                <th scope="col"><span class="main-grid-head-title">Активность</span></th>
                <th scope="col"><span class="main-grid-head-title">Упаковка / Единица</span></th>
                <th scope="col"><span class="main-grid-head-title">Закупочная Цена</span></th>
                <th scope="col"><span class="main-grid-head-title">Розничная Цена</span></th>
                <th scope="col"><span class="main-grid-head-title">Служебная Информация</span></th>
                <th scope="col"><span class="main-grid-head-title">Наличие Товара</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class="js-product-item">
                    <td>
                        <div class="form-check">
                            <input class="form-check-input position-static" type="checkbox">
                        </div>
                    </td>
                    <td><span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product['id'])}}">{{$product['id']}}</a></span></td>
                    <td><span class="main-grid-cell-content">{{$product['ordering']}}</td>
                    <td><span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product['id'])}}">{!! $product['name'] !!}</a></span></td>
                    <td><span class="main-grid-cell-content">{{$product['is_active_name']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product['unit']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product['price_purchase_formatted']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product['price_retail_formatted']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product['admin_comment']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product['availability_status_name']}}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $products->links("admin.pagination.default") }}
</div>
