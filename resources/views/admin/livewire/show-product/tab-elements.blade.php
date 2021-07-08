<?php
/**
 * @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
 * @var array[]|\Domain\Products\DTOs\InformationalPriceDTO[] $infoPrices
 * @var array[] $instructions {@see \Domain\Common\DTOs\FileDTO}
 * @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 * @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 * @var bool $generateSlugSyncMode
 * @var bool $is_with_variations
 */
?>

<div class="item-edit product-edit">
    @if(!$isCreating)
        <div class="form-group row">
            <label for="item.name" class="col-sm-5 col-form-label">ID:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item['id']}}
            </div>
        </div>
    @endif

    @include('admin.livewire.includes.form-group-checkbox', ['field' => 'item.is_active', 'label' => 'Активность'])

    <div class="form-group row">
        <label for="item.name" class="col-sm-5 col-form-label font-weight-bold">Название:</label>
        <div class="col-sm-7">
            <div class="input-group">
                <input wire:model.debounce.1000ms="item.name" type="text" class="form-control @error('item.name') is-invalid @enderror" id="item.name">
                <div class="input-group-append">
                    <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
                </div>
            </div>
            @error('item.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="item.slug" class="col-sm-5 col-form-label font-weight-bold">Символьный код:</label>
        <div class="col-sm-7">
            <div class="input-group @error('item.slug') is-invalid @enderror">
                <input wire:model.defer="item.slug" type="text" class="form-control @error('item.slug') is-invalid @enderror" id="item.slug">
                <div class="input-group-append">
                    <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
                </div>
            </div>
            @error('item.slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    @include('admin.livewire.includes.form-group-input', ['field' => 'item.ordering', 'className' => 'width-27', 'label' => 'Сортировка'])

    @include('admin.livewire.includes.form-group-select', ['field' => 'item.brand_id', 'className' => 'width-45', 'label' => 'Производитель', 'options' => $brands])

    <div class="form-group row">
        <label for="item.coefficient" class="col-sm-5 col-form-label">Коэффициент на единицу расхода:</label>
        <div class="col-sm-2">
            <input wire:model.defer="item.coefficient" type="text" class="form-control @error('item.coefficient') is-invalid @enderror" id="item.coefficient">
            @error('item.coefficient') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-sm-5">
            <div class="form-inline">
                <label for="item.coefficient_description" class="text-left mr-2">Описание коэффициента:</label>
                <input wire:model.defer="item.coefficient_description" type="text" class="form-control @error('item.coefficient_description') is-invalid @enderror" id="item.coefficient_description">
                @error('item.coefficient_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    @include('admin.livewire.includes.form-group-checkbox', ['field' => 'item.coefficient_description_show', 'label' => 'Показывать описание коэффициента'])

    @if($is_with_variations)
        @include('admin.livewire.includes.form-group-input', ['field' => 'item.coefficient_variation_description', 'className' => 'width-27', 'label' => 'Описание столбца коэффициента вариантов'])
    @endif

    @include('admin.livewire.includes.form-group-input', ['field' => 'item.price_name', 'className' => 'width-50', 'label' => 'Наименование цены'])

    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Информационные цены:</label>
        <div class="col-sm-7">
            @foreach($infoPrices as $index => $infoPrice)
                <div wire:key="product-info-price-{{$infoPrice['temp_uuid']}}" class="row mb-2">
                    <div class="col-sm-3">
                        <input wire:model.defer="infoPrices.{{$infoPrice['temp_uuid']}}.price" type="text" class="form-control @error("infoPrices.$infoPrice[temp_uuid].price") is-invalid @enderror" placeholder="Цена">
                        @error("infoPrices.$infoPrice[temp_uuid].price") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-7">
                        <input wire:model.defer="infoPrices.{{$infoPrice['temp_uuid']}}.name" type="text" class="form-control @error("infoPrices.$infoPrice[temp_uuid].name") is-invalid @enderror" placeholder="Описание">
                        @error("infoPrices.$infoPrice[temp_uuid].name") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-2">
                        <button wire:click="deleteInfoPrice('{{$infoPrice['temp_uuid']}}')" type="button" class="btn btn-outline-danger btn__remove">x</button>
                    </div>
                </div>
            @endforeach
            <button wire:click="addInfoPrice" type="button" class="btn btn__default">Добавить</button>
        </div>
    </div>

    @include('admin.livewire.includes.form-group-textarea', ['field' => 'item.admin_comment', 'label' => 'Служебная информация'])

    <div class="form-group row">
        <label class="col-sm-5 col-form-label">Дополнительные файлы (инструкции):</label>
        <div class="col-sm-7">
            <div class="add-file">
                <div class="row">
                    @foreach($instructions as $index => $instruction)
                        <div wire:key="instructions-{{$index}}-{{$instruction['url']}}" class="card text-center">
                            <div class="adm-fileinput-item-preview">
                                <h5 class="card-title"><a href="{{$instruction['url']}}" target="_blank">{{$instruction['file_name']}}</a></h5>
                            </div>
                            <div class="form-group">
                                @include('admin.livewire.includes.form-control-input', ['field' => "instructions.$index.name"])
                            </div>
                            <button wire:click="deleteInstruction({{$index}})" type="button" class="adm-fileinput-item-preview__remove">&nbsp;</button>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <div>
                        <span class="add-file__text" wire:model="tempInstruction">Перетащите файлы  в эту область (Drag&Drop)</span>
                        <input type="file" wire:model="tempInstruction" class="form-control-file @error("tempInstruction") is-invalid @enderror" id="tempInstruction" />
                        <div wire:loading wire:target="tempInstruction">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    @error("tempInstruction") <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="price_purchase" class="col-sm-5 col-form-label font-weight-bold">Закупочная цена:</label>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-3">
                    @include('admin.livewire.includes.form-control-input', ['field' => "item.price_purchase"])
                </div>
                <div class="col-5">
                    @include('admin.livewire.includes.form-group-select', ['field' => 'item.price_purchase_currency_id', 'label' => 'Валюта', 'options' => $currencies])
                </div>
            </div>

        </div>
    </div>

    <div class="form-group row">
        <label for="price_retail" class="col-sm-5 col-form-label font-weight-bold">Розничная цена:</label>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-3">
                    @include('admin.livewire.includes.form-control-input', ['field' => "item.price_retail"])
                </div>
                <div class="col-5">
                    @include('admin.livewire.includes.form-group-select', ['field' => 'item.price_retail_currency_id', 'label' => 'Валюта', 'options' => $currencies])
                </div>
            </div>
        </div>
    </div>

    @include('admin.livewire.includes.form-group-input', ['field' => 'item.unit', 'className' => 'width-27', 'label' => 'Упаковка / Единица'])

    @include('admin.livewire.includes.form-group-select', ['field' => 'item.availability_status_id', 'className' => 'width-35', 'label' => 'Наличие', 'options' => $availabilityStatuses])
</div>
