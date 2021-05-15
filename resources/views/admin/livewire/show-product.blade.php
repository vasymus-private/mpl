<?php
/** @var \Domain\Products\Models\Product\Product $product */
/** @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand} */
/** @var array[]|\Domain\Products\DTOs\InformationalPriceDTO[] $infoPrices */
/** @var array[] $instructions {@see \Domain\Common\DTOs\InstructionDTO} */
/** @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
/** @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency} */
?>
<div>
    <ul class="nav nav-tabs" id="show-product-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="elements-tab" data-toggle="tab" href="#elements" role="tab" aria-controls="elements" aria-selected="false">Элемент</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Описание</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="false">Фото</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="characteristics-tab" data-toggle="tab" href="#characteristics" role="tab" aria-controls="characteristics" aria-selected="false">Характеристики</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="accessories-tab" data-toggle="tab" href="#accessories" role="tab" aria-controls="accessories" aria-selected="false">Аксессуары</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="similar-tab" data-toggle="tab" href="#similar" role="tab" aria-controls="similar" aria-selected="false">Похожие</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="related-tab" data-toggle="tab" href="#related" role="tab" aria-controls="related" aria-selected="false">Сопряжённые</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="works-tab" data-toggle="tab" href="#works" role="tab" aria-controls="works" aria-selected="false">Работы</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="variations-tab" data-toggle="tab" href="#variations" role="tab" aria-controls="variations" aria-selected="false">Варианты</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="other-tab" data-toggle="tab" href="#other" role="tab" aria-controls="other" aria-selected="false">Прочее</a>
        </li>
    </ul>
    <form wire:submit.prevent="save">
        <div class="tab-content" id="show-product-tab-content">

                <div class="tab-pane fade" id="elements" role="tabpanel" aria-labelledby="elements-tab">

                    @include('admin.livewire.includes.form-group-checkbox', ['field' => 'product.is_active', 'label' => 'Активность'])

                    @include('admin.livewire.includes.form-group-input', ['field' => 'product.name', 'label' => 'Название'])

                    @include('admin.livewire.includes.form-group-input', ['field' => 'product.slug', 'label' => 'Символьный код'])

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
                                    <div wire:key="instructions-{{$index}}-{{$instruction['path']}}" class="card text-center">
                                        <div class="card-body">
                                            <p class="card-text">{{$instruction['mime_type_name']}}</p>
                                            <h5 class="card-title"><a href="{{$instruction['path']}}" target="_blank">{{$instruction['file_name']}}</a></h5>
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
                                    Loading...
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

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>

                <div class="tab-pane fade show active p-3" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <textarea name="" id="tinymce" cols="30" rows="10" class="tinymce"></textarea>
                </div>

                <div class="tab-pane fade" id="photo" role="tabpanel" aria-labelledby="photo-tab">
                    photo
                </div>

                <div class="tab-pane fade" id="characteristics" role="tabpanel" aria-labelledby="characteristics-tab">
                    characteristics
                </div>

                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    seo
                </div>

                <div class="tab-pane fade" id="accessories" role="tabpanel" aria-labelledby="accessories-tab">
                    accessories
                </div>

                <div class="tab-pane fade" id="similar" role="tabpanel" aria-labelledby="similar-tab">
                    similar
                </div>

                <div class="tab-pane fade" id="related" role="tabpanel" aria-labelledby="related-tab">
                    related
                </div>

                <div class="tab-pane fade" id="works" role="tabpanel" aria-labelledby="works-tab">
                    works
                </div>

                <div class="tab-pane fade" id="variations" role="tabpanel" aria-labelledby="variations-tab">
                    variations
                </div>

                <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                    other
                </div>


        </div>
    </form>

</div>
