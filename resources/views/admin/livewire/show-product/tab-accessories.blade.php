@include('admin.livewire.includes.form-group-input', ['field' => 'product.accessory_name', 'label' => 'Переименовать аксессуары'])

@foreach($productProducts as $productProductItem)
    <div class="row">

    </div>
@endforeach

<div class="row">
    <div class="col">
        @include('admin.livewire.includes.form-group-select', ['field' => 'searchForProductProduct.' . \Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY . '.category_id', 'label' => 'Категория', 'options' => $categories, 'isRow' => false])
    </div>
    <div class="col">
        @include('admin.livewire.includes.form-group-input', ['field' => 'searchForProductProduct.' . \Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY . '.product_name', 'label' => 'Название', 'isRow' => false])
    </div>
    <div class="col align-self-center">
        <button wire:click="loadProductProduct({{\Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY}})" type="button" class="btn btn-primary mb-2">Ok</button>
    </div>
</div>

@if(count($loadedForProductProduct))
<table class="table">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Название</th>
        <th>Цена</th>
    </tr>
    </thead>
    <tbody>
        @foreach($loadedForProductProduct[\Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY] as $index => $loadedProductProduct)
            <tr>
                <td><input id="loadedForProductProduct.{{\Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY}}.{{$index}}.isSelected" wire:model="loadedForProductProduct.{{\Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY}}.{{$index}}.isSelected" type="checkbox" /></td>
                <td><label class="w-100" for="loadedForProductProduct.{{\Domain\Products\Models\Pivots\ProductProduct::TYPE_ACCESSORY}}.{{$index}}.isSelected">{{$loadedProductProduct['name']}}</label></td>
                <td>{{$loadedProductProduct['price_rub_formatted']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
