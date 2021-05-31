<?php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator|array[] $products @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
 * @var string $currentRoute
 * @var string $newRoute
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 * @var string|int|null $brand_id
 * @var string|int|null $brand_name
 * @var string|int $total
 * @var array[] $per_page_options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
 */
?>
<div>
    <form wire:submit.prevent="handleSearch" method="GET">
        <div class="search form-group row">
            <div class="col-xs-12 col-sm-8">
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
                    <input wire:model.defer="search" type="text" class="form-control" placeholder="Фильтр + поиск" aria-label="Фильтр + поиск" aria-describedby="search-button">
                    <div class="input-group-append">
                        <button wire:click.prevent="clearAllFilters" class="btn-outline-secondary" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <button class="btn-outline-secondary search-icon" type="submit" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2">
                @include('admin.livewire.includes.form-control-select', [
                    'field' => 'brand_id',
                    'options' => $brands,
                    'placeholder' => 'Производитель',
                    'wire' => ['change' => 'handleSearch']
                ])
            </div>
            <div class="col-xs-12 col-sm-2">
                <div class="dropdown">
                    <a href="#" wire:click.prevent="newItem" class="btn btn-add btn-secondary">Создать</a>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive position-relative">
        <div wire:loading>
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input class="form-check-input position-static" type="checkbox" id="check-all" aria-label="Check all">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                <th scope="col"><span class="main-grid-head-title">Сортировка</span></th>
                <th scope="col"><span class="main-grid-head-title">Название</span></th>
                <th scope="col"><span class="main-grid-head-title">Активность</span></th>
                <th scope="col"><span class="main-grid-head-title">Упаковка</span></th>
                <th scope="col"><span class="main-grid-head-title">Закупочная</span></th>
                <th scope="col"><span class="main-grid-head-title">Розничная</span></th>
                <th scope="col"><span class="main-grid-head-title">Служебная Информация</span></th>
                <th scope="col"><span class="main-grid-head-title">Наличие</span></th>
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
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary" type="button" id="actions-dropdown-{{$product['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></button>
                            <div class="dropdown-menu" aria-labelledby="actions-dropdown-{{$product['id']}}">
                                <a class="dropdown-item" href="#">Изменить</a>
                                <a class="dropdown-item" href="#">Деактивировать</a>
                                <a class="dropdown-item" href="#">Копировать</a>
                                <a class="dropdown-item" href="#">Удалить</a>
                            </div>
                        </div>
                    </td>
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

    <div class="row">
        <div class="col-sm-1">
            Всего: {{$total}}
        </div>
        <div class="col-sm-9">
            {{ $products->links("admin.pagination.livewire-bootstrap") }}
        </div>
        <div class="col-sm-2">
            @include('admin.livewire.includes.form-group-select', ['field' => 'per_page', 'label' => 'На странице', 'options' => $per_page_options, 'wire' => ['change' => 'handleSearch']])
        </div>
    </div>
</div>
