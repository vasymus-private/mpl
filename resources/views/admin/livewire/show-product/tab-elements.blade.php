<?php
/** @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand} */
/** @var array[]|\Domain\Products\DTOs\InformationalPriceDTO[] $infoPrices */
/** @var array[] $instructions {@see \Domain\Common\DTOs\FileDTO} */
/** @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
/** @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
/** @var bool $generateSlugSyncMode */
?>
@include('admin.livewire.includes.form-group-checkbox', ['field' => 'product.is_active', 'label' => 'Активность'])

<div class="form-group row">
    <label for="product.name" class="col-sm-3 col-form-label font-weight-bold">Название:</label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input wire:model.debounce.1000ms="product.name" type="text" class="form-control @error('product.name') is-invalid @enderror" id="product.name">
            <div class="input-group-append">
                <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
            </div>
        </div>
        @error('product.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group row">
    <label for="product.slug" class="col-sm-3 col-form-label">Символьный код:</label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input wire:model.defer="product.slug" type="text" class="form-control @error('product.slug') is-invalid @enderror" id="product.slug">
            <div class="input-group-append">
                <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
            </div>
        </div>
        @error('product.slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

@include('admin.livewire.includes.form-group-input', ['field' => 'product.ordering', 'label' => 'Сортировка'])

@include('admin.livewire.includes.form-group-select', ['field' => 'product.brand_id', 'label' => 'Производитель', 'options' => $brands])

@include('admin.livewire.includes.form-group-input', ['field' => 'product.coefficient', 'label' => 'Коэффициент на единицу расхода и единица расхода'])

@include('admin.livewire.includes.form-group-input', ['field' => 'product.coefficient_description', 'label' => 'Описание коэффициента'])

@include('admin.livewire.includes.form-group-checkbox', ['field' => 'product.coefficient_description_show', 'label' => 'Показывать описание коэффициента'])

@include('admin.livewire.includes.form-group-input', ['field' => 'product.price_name', 'label' => 'Наименование цены'])

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Информационные цены:</label>
    <div class="col-sm-9">
        @foreach($infoPrices as $index => $infoPrice)
            <div wire:key="product-info-price-{{$infoPrice['temp_uuid']}}" class="row mb-2">
                <div class="col-sm-5">
                    <input wire:model.defer="infoPrices.{{$infoPrice['temp_uuid']}}.price" type="text" class="form-control @error("infoPrices.$infoPrice[temp_uuid].price") is-invalid @enderror" placeholder="Цена">
                    @error("infoPrices.$infoPrice[temp_uuid].price") <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-sm-5">
                    <input wire:model.defer="infoPrices.{{$infoPrice['temp_uuid']}}.name" type="text" class="form-control @error("infoPrices.$infoPrice[temp_uuid].name") is-invalid @enderror" placeholder="Описание">
                    @error("infoPrices.$infoPrice[temp_uuid].name") <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-sm-2">
                    <button wire:click="deleteInfoPrice('{{$infoPrice['temp_uuid']}}')" type="button" class="btn btn-outline-danger">x</button>
                </div>
            </div>
        @endforeach
        <button wire:click="addInfoPrice" type="button" class="btn btn-primary">Добавить</button>
    </div>
</div>

@include('admin.livewire.includes.form-group-textarea', ['field' => 'admin_comment', 'label' => 'Служебная информация'])

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Дополнительные файлы (инструкции):</label>
    <div class="col-sm-9">
        <div class="row">
            @foreach($instructions as $index => $instruction)
                <div wire:key="instructions-{{$index}}-{{$instruction['url']}}" class="card text-center">
                    <div class="card-body">
                        <p class="card-text">{{$instruction['mime_type_name']}}</p>
                        <h5 class="card-title"><a href="{{$instruction['url']}}" target="_blank">{{$instruction['file_name']}}</a></h5>
                        <div class="form-group">
                            @include('admin.livewire.includes.form-control-input', ['field' => "instructions.$index.name"])
                        </div>
                        <button wire:click="deleteInstruction({{$index}})" type="button" class="btn btn-outline-danger">x</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="tempInstruction">Добавить инструкцию</label>
            <input type="file" wire:model="tempInstruction" class="form-control-file @error("tempInstruction") is-invalid @enderror" id="tempInstruction" />
            <div wire:loading wire:target="tempInstruction">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            @error("tempInstruction") <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="price_purchase" class="col-sm-3 col-form-label">Закупочная цена:</label>
    <div class="col-sm-9">
        <div class="row">
            <div class="col">
                @include('admin.livewire.includes.form-control-input', ['field' => "product.price_purchase"])
            </div>
            <div class="col">
                @include('admin.livewire.includes.form-group-select', ['field' => 'product.price_purchase_currency_id', 'label' => 'Валюта', 'options' => $currencies])
            </div>
        </div>

    </div>
</div>

<div class="form-group row">
    <label for="price_retail" class="col-sm-3 col-form-label">Розничная цена:</label>
    <div class="col-sm-9">
        <div class="row">
            <div class="col">
                @include('admin.livewire.includes.form-control-input', ['field' => "product.price_retail"])
            </div>
            <div class="col">
                @include('admin.livewire.includes.form-group-select', ['field' => 'product.price_retail_currency_id', 'label' => 'Валюта', 'options' => $currencies])
            </div>
        </div>
    </div>
</div>

@include('admin.livewire.includes.form-group-input', ['field' => 'product.unit', 'label' => 'Упаковка / Единица'])

@include('admin.livewire.includes.form-group-select', ['field' => 'product.availability_status_id', 'label' => 'Наличие', 'options' => $availabilityStatuses])
