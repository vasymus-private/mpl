<?php
/** @var string[] $tabs */
/** @var string $activeTab */
/** @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand} */
/** @var array[]|\Domain\Products\DTOs\InformationalPriceDTO[] $infoPrices */
/** @var array[] $instructions {@see \Domain\Common\DTOs\InstructionDTO} */
/** @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
/** @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
?>
<div class="py-4">
    <ul class="nav nav-tabs" id="show-product-tabs" role="tablist">
        @foreach($tabs as $tab => $label)
            <li class="nav-item" role="presentation">
                <a wire:ignore wire:click="selectTab('{{$tab}}')" class="nav-link @if($tab === $activeTab) active @endif" data-toggle="tab" id="{{$tab}}-tab" href="#{{$tab}}" role="tab" aria-controls="elements" aria-selected="{{$tab === $activeTab ? 'true' : 'false'}}">{{$label}}</a>
            </li>
        @endforeach
    </ul>
    <form wire:submit.prevent="save">
        <div class="tab-content" id="show-product-tab-content">
            @foreach($tabs as $tab => $label)
                <div wire:ignore.self class="tab-pane p-3 fade @if($tab === $activeTab) show active @endif" id="{{$tab}}" role="tabpanel" aria-labelledby="{{$tab}}-tab">
                    @include("admin.livewire.show-product.tab-$tab")
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    </form>
</div>
