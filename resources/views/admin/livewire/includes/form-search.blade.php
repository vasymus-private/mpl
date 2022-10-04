<?php
/**
 * @var string $submit
 * @var string $newRoute
 * @var string $clearAll
 * @var array[] $prepends @see {@link \Domain\Common\DTOs\SearchPrependAdminDTO}
 * @var bool $brandFilter
 */
?>
<div wire:key="form-search-row" class="search form-group row">
    <div wire:key="form-search-col-1" class="col-xs-12 col-sm-8">
        <div class="input-group mb-3">
            @foreach($prepends as $prepend)
                <div wire:key="form-search-prepend-{{$prepend['label']}}" class="input-group-prepend">
                    <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{$prepend['label']}}</span>
                    <button wire:click.prevent="{{$prepend['onClear']}}" class="btn input-group-prepend__remove" type="button"></button>
                </div>
            @endforeach
            <input wire:model.defer="search" type="text" class="form-control" placeholder="Фильтр + поиск" aria-label="Фильтр + поиск" aria-describedby="search-button">
            <div class="input-group-append">
                <button wire:click.prevent="{{$clearAll}}" class="btn-outline-secondary" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                <button wire:click="{{$submit ?? 'handleSearch'}}" class="btn-outline-secondary search-icon" type="button" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    @if($brandFilter ?? null)
        <div  wire:key="form-search-col-2" class="col-xs-12 col-sm-2">
            @include('admin.livewire.includes.form-control-select', [
                'field' => 'brand_id',
                'options' => $brands,
                'placeholder' => 'Производитель',
                'wire' => ['change' => $submit ?? 'handleSearch']
            ])
        </div>
    @endif
    @if($newRoute ?? null)
        <div wire:key="form-search-col-3" class="col-xs-12 col-sm-2">
            <div class="dropdown">
                <a href="{{$newRoute}}" class="btn btn-add btn-secondary">Создать</a>
            </div>
        </div>
    @endif
</div>
