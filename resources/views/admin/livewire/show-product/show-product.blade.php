<?php
/** @var \App\Http\Livewire\Admin\ShowProduct $this */
/** @var string $activeTab */
/** @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand} */
/** @var array[]|\Domain\Products\DTOs\InformationalPriceDTO[] $infoPrices */
/** @var array[] $instructions {@see \Domain\Common\DTOs\FileDTO} */
/** @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
/** @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
?>
<div class="py-4">
    @if($product->id)
        <div class="row pb-4">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Параметры товара
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" wire:click="setWithVariations(false)" href="#">@if(!$is_with_variations)<i class="fa fa-check" aria-hidden="true"></i>@endif Товар без вариантов</a>
                    <a class="dropdown-item" wire:click="setWithVariations(true)" href="#">@if($is_with_variations)<i class="fa fa-check" aria-hidden="true"></i>@endif Товар с вариантами</a>
                </div>
            </div>
        </div>
    @endif
    <ul class="nav nav-tabs" id="show-product-tabs" role="tablist">
        @foreach($tabs as $tab => $label)
            <li wire:key="{{ $tab }}" class="nav-item @if(!$is_with_variations && $tab === 'variations') d-none @endif" role="presentation">
                <a wire:click="selectTab('{{$tab}}')" wire:ignore.self class="nav-link @if($tab === $activeTab) active @endif" data-toggle="tab" id="{{$tab}}-tab" href="#{{$tab}}" role="tab" aria-controls="{{$tab}}" aria-selected="{{$tab === $activeTab ? 'true' : 'false'}}">{{$label}}</a>
            </li>
        @endforeach
    </ul>
    <form wire:submit.prevent="save">
        <div class="tab-content" id="show-product-tab-content">
            @foreach($tabs as $tab => $label)
                    <div wire:key="{{ $tab }}"  wire:ignore.self class="tab-pane p-3 fade @if($tab === $activeTab) show active @endif" id="{{$tab}}" role="tabpanel" aria-labelledby="{{$tab}}-tab">
                        <div class="@if(!$is_with_variations && $tab === 'variations') d-none @endif">
                            @include("admin.livewire.show-product.tab-$tab")
                        </div>
                    </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
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
