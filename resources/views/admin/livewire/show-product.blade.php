<?php
/** @var \Domain\Products\Models\Product\Product $product */
/** @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Brand[] $brands */
/** @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\InformationalPrice[] $infoPrices */
/** @var array[] $instructions {@see \Domain\Common\DTOs\InstructionDTO} */
/** @var \Illuminate\Database\Eloquent\Collection|\Domain\Common\Models\Currency[] $currencies */
/** @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\AvailabilityStatus[] $availabilityStatuses */
?>
<div>
    <ul class="nav nav-tabs" id="show-product-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="elements-tab" data-toggle="tab" href="#elements" role="tab" aria-controls="elements" aria-selected="true">Элемент</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="false">Описание</a>
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
    <div class="tab-content" id="show-product-tab-content">
        <div class="tab-pane fade show active p-3" id="elements" role="tabpanel" aria-labelledby="elements-tab">
            <form wire:submit.prevent="save">

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-check-label" for="is_active">
                            Активность:
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input wire:model="product.is_active" class="form-check-input" type="checkbox" id="is_active">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Название:</label>
                    <div class="col-sm-9">
                        <input wire:model.defer="product.name" type="text" class="form-control" id="name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-sm-3 col-form-label">Символьный код:</label>
                    <div class="col-sm-9">
                        <input wire:model.defer="product.slug" type="text" class="form-control" id="slug">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ordering" class="col-sm-3 col-form-label">Сортировка:</label>
                    <div class="col-sm-9">
                        <input wire:model.defer="product.ordering" type="text" class="form-control" id="ordering">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="brand_id" class="col-sm-3 col-form-label">Производитель:</label>
                    <div class="col-sm-9">
                        <select wire:model.defer="product.brand_id" class="form-control" id="brand_id">
                            <option value="">(не установлено)</option>
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="coefficient" class="col-sm-3 col-form-label">Коэффициент на единицу расхода и единица расхода:</label>
                    <div class="col-sm-9">
                        <input wire:model.defer="product.coefficient" type="text" class="form-control" id="coefficient">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="coefficient_description" class="col-sm-3 col-form-label">Описание коэффициента:</label>
                    <div class="col-sm-9">
                        <input wire:model.defer="product.coefficient_description" type="text" class="form-control" id="coefficient_description">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-check-label" for="coefficient_description_show">
                            Показывать описание коэффициента:
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input wire:model="product.coefficient_description_show" class="form-check-input" type="checkbox" id="coefficient_description_show">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price_name" class="col-sm-3 col-form-label">Наименование цены:</label>
                    <div class="col-sm-9">
                        <input wire:model.defer="product.price_name" type="text" class="form-control" id="price_name">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Информационные цены:</label>
                    <div class="col-sm-9">
                        @foreach($infoPrices as $index => $infoPrice)
                            <div wire:key="product-info-price-{{$infoPrice->id}}" class="row mb-2">
                                <div class="col-sm-5">
                                    <input wire:model.defer="infoPrices.{{$index}}.price" type="text" class="form-control" placeholder="Цена">
                                </div>
                                <div class="col-sm-5">
                                    <input wire:model.defer="infoPrices.{{$index}}.name" type="text" class="form-control" placeholder="Описание">
                                </div>
                                <div class="col-sm-2">
                                    <button wire:click="deleteInfoPrice({{$infoPrice->id}})" type="button" class="btn btn-outline-danger">x</button>
                                </div>
                            </div>
                        @endforeach
                        <button wire:click="addInfoPrice" type="button" class="btn btn-primary">Добавить</button>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="admin_comment" class="col-sm-3 col-form-label">Служебная информация:</label>
                    <div class="col-sm-9">
                        <textarea wire:model.defer="product.admin_comment" class="form-control" id="admin_comment" rows="3"></textarea>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Дополнительные файлы (инструкции):</label>
                    <div class="col-sm-9">
                        <div class="row">
                            @foreach($instructions as $index => $instruction)
                                <div wire:key="instructions-{{$index}}-{{$instruction['path']}}" class="card text-center">
                                    <div class="card-body">
                                        <p class="card-text">{{$instruction['mime_type_name']}}</p>
                                        <h5 class="card-title">{{$instruction['file_name']}}</h5>
                                        <div class="form-group">
                                            <input wire:model.defer="instructions.{{$index}}.name" class="form-control" type="text" />
                                        </div>
                                        <button wire:click="deleteInstruction({{$index}})" type="button" class="btn btn-outline-danger">x</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="tempInstruction">Добавить инструкцию</label>
                            <input type="file" wire:model="tempInstruction" class="form-control-file" id="tempInstruction" />
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price_purchase" class="col-sm-3 col-form-label">Закупочная цена:</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col">
                                <input wire:model.defer="product.price_purchase" type="text" class="form-control" id="price_purchase" placeholder="Цена">
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label for="price_purchase_currency_id" class="col-sm-3 col-form-label">Валюта:</label>
                                    <div class="col-sm-9">
                                        <select wire:model.defer="product.price_purchase_currency_id" class="form-control" id="price_purchase_currency_id">
                                            <option value="">(не установлено)</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}">{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="price_retail" class="col-sm-3 col-form-label">Розничная цена:</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col">
                                <input wire:model.defer="product.price_retail" type="text" class="form-control" id="price_retail" placeholder="Цена">
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label for="price_retail_currency_id" class="col-sm-3 col-form-label">Валюта:</label>
                                    <div class="col-sm-9">
                                        <select wire:model.defer="product.price_retail_currency_id" class="form-control" id="price_retail_currency_id">
                                            <option value="">(не установлено)</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}">{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="unit" class="col-sm-3 col-form-label">Упаковка / Единица:</label>
                    <div class="col-sm-9">
                        <input wire:model.defer="product.unit" type="text" class="form-control" id="unit">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="availability_status_id" class="col-sm-3 col-form-label">Наличие:</label>
                    <div class="col-sm-9">
                        <select wire:model.defer="product.availability_status_id" class="form-control" id="availability_status_id">
                            <option value="">(не установлено)</option>
                            @foreach($availabilityStatuses as $availabilityStatus)
                                <option value="{{$availabilityStatus->id}}">{{$availabilityStatus->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>




                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            <style>
                input:invalid {
                    border: red;
                }
            </style>
        </div>
        <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
            description
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

</div>
