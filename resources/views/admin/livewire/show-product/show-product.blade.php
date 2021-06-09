<?php
/**
 * @var \App\Http\Livewire\Admin\ShowProduct $this
 * @var \Domain\Products\Models\Product\Product $item @see {@link \App\Http\Livewire\Admin\ShowProduct::$item}
 * @var string $activeTab @see {@link \App\Http\Livewire\Admin\ShowProduct::$activeTab}
 * @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand} {@link \App\Http\Livewire\Admin\ShowProduct::$brands}
 * @var array[]|\Domain\Products\DTOs\InformationalPriceDTO[] $infoPrices @see {@link \App\Http\Livewire\Admin\ShowProduct::$infoPrices}
 * @var array[] $instructions @see {@link \Domain\Common\DTOs\FileDTO} {@link \App\Http\Livewire\Admin\ShowProduct::$instructions}
 * @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} {@link \App\Http\Livewire\Admin\ShowProduct::$currencies}
 * @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} {@link \App\Http\Livewire\Admin\ShowProduct::$availabilityStatuses}
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
<div class="py-4">
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <a href="{{route('admin.products.index', ['category_id' => $item->category_id])}}" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Товары</span>
                    <span class="detail-toolbar__btn-r"></span>
                </a>
            </div>
            @if($item->id)
                <div class="col-sm-5 d-flex align-items-center">
                    <a href="#" class="detail-toolbar__copy">Копировать</a>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Параметры товара
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" wire:click="setWithVariations(false)" href="#">@if(!$is_with_variations)<i class="fa fa-check" aria-hidden="true"></i>@endif Товар без вариантов</a>
                            <a class="dropdown-item" wire:click="setWithVariations(true)" href="#">@if($is_with_variations)<i class="fa fa-check" aria-hidden="true"></i>@endif Товар с вариантами</a>
                        </div>
                    </div>
                    <div class="dropdown actions">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="add">Действия</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" wire:click="setWithVariations(false)" href="#">
                                <span class="bx-core-popup-menu-item-icon edit"></span>
                                Добавить элемент
                            </a>
                            <a class="dropdown-item" wire:click="setWithVariations(true)" href="#">
                                <span class="bx-core-popup-menu-item-icon delete"></span>
                                Удалить элемент
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <ul class="nav nav-tabs item-tabs" role="tablist">
        @foreach($tabs as $tab => $label)
            <li wire:key="{{ $tab }}" class="nav-item @if(!$is_with_variations && $tab === 'variations') d-none @endif" role="presentation">
                <a wire:click="selectTab('{{$tab}}')" wire:ignore.self class="nav-link @if($tab === $activeTab) active @endif" data-toggle="tab" id="{{$tab}}-tab" href="#{{$tab}}" role="tab" aria-controls="{{$tab}}" aria-selected="{{$tab === $activeTab ? 'true' : 'false'}}">{{$label}}</a>
            </li>
        @endforeach
    </ul>
    <form wire:submit.prevent="save">
        <div class="tab-content">
            @foreach($tabs as $tab => $label)
                    <div wire:key="{{ $tab }}"  wire:ignore.self class="tab-pane p-3 fade @if($tab === $activeTab) show active @endif" id="{{$tab}}" role="tabpanel" aria-labelledby="{{$tab}}-tab">
                        <div class="@if(!$is_with_variations && $tab === 'variations') d-none @endif">
                            @include("admin.livewire.show-product.tab-$tab")
                        </div>
                    </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mb-2 btn__save">Сохранить</button>

        @foreach($errors->all() as $error)
            <div wire:key="{{$error}}" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    </form>
</div>
