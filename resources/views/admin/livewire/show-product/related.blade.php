<?php
/**
 * @var string $title
 * @var int $type
 * @var string $wire_field
 * @var array[][] $productProducts @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
 * @var array[] $categoriesSelectOptions @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category} {@link \App\Http\Livewire\Admin\ShowProduct\ShowProduct::$categoriesSelectOptions}
 * @var array[][] $loadedForProductProduct @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
 */
?>
@include('admin.livewire.includes.form-group-input', ['field' => "item.$wire_field", 'label' => "Переименовать '$title'"])

<p class="h3">{{$title}}</p>
@foreach(collect($productProducts[$type])->chunk(3) as $chunk)
    <div class="row">
        @foreach($chunk as $productProductItem)
            <div class="col-sm-4">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4 d-flex justify-content-center">
                            <img class="align-self-center mw-100" src="{{$productProductItem['image']}}" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="h6 card-title"><a target="_blank" href="{{$productProductItem['url']}}">{{$productProductItem['name']}}</a></p>
                                <p class="card-text"><small class="text-muted">{{$productProductItem['price_rub_formatted']}}</small></p>
                                <div class="form-check">
                                    <input wire:model.defer="{{$productProductItem['wireModelPrefix']}}toDelete" class="form-check-input" type="checkbox" id="{{$productProductItem['wireModelPrefix']}}toDelete">
                                    <label class="form-check-label" for="{{$productProductItem['wireModelPrefix']}}toDelete">
                                        Удалить
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach

<div class="row">
    <div class="col">
        @include(
            'admin.livewire.includes.form-group-select',
            [
                'field' => "searchForProductProduct.$type.category_id",
                'label' => 'Категория',
                'options' => $categoriesSelectOptions,
                'isRow' => false,
                'wire' => ['change' => "loadProductProduct($type)"]
            ]
        )
    </div>
    <div class="col">
        <label for="basic-url">Название:</label>
        <div class="input-group mb-3">
            <input wire:model.defer="searchForProductProduct.{{$type}}.product_name" type="text" class="form-control" id="searchForProductProduct.{{$type}}.product_name" />
            <div class="input-group-append">
                <button wire:click="loadProductProduct({{$type}})" class="btn btn-outline-secondary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>

@if(count($loadedForProductProduct))
    <table class="table" wire:loading.remove wire:target="loadProductProduct({{$type}})">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Название</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($loadedForProductProduct[$type] as $loadedProductProduct)
            <tr>
                <td><input id="{{$loadedProductProduct['wireModelPrefix']}}isSelected" wire:model="{{$loadedProductProduct['wireModelPrefix']}}isSelected" type="checkbox" /></td>
                <td><label class="w-100 mb-0" for="{{$loadedProductProduct['wireModelPrefix']}}isSelected">{{$loadedProductProduct['name']}}</label></td>
                <td>{{$loadedProductProduct['price_rub_formatted']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<div wire:loading wire:target="loadProductProduct({{$type}})">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<p><small>Будут показаны только первые 20 результатов</small></p>
