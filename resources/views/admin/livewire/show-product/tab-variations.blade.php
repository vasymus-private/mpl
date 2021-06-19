<?php
/**
 * @var \App\Http\Livewire\Admin\ShowProduct\ShowProduct $this
 * @var array[] $variations @see {@link \Domain\Products\DTOs\Admin\VariationDTO}
 * @var array $currentVariation @see {@link \Domain\Products\DTOs\Admin\VariationDTO}
 * @var bool $variationsEditMode
 * @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 * @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 */
?>
@if($this->isCreatingFromCopy)
    <p class="text-danger">Чтобы редактировать товарные предложения, необходимо сохранить скопированный товар.</p>
@else
    <div class="admin-edit-variations">
        <div class="admin-edit-variations__header">
            <button onclick="@this.setCurrentVariation().then(() => {$('#current-variation').modal('show')})" type="button" data-target="#current-variation" class="btn btn__add">Добавить элемент</button>
            {{--<button class="btn btn__default">Добавить предложение с набором</button>
            <button class="btn btn__default">Обновить список</button>
            <button class="btn btn__default">Генерировать торговые предложения</button>--}}
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="width: 3000px;">
                <thead>
                <tr>
                    <th>
                        <div class="form-check form-check-inline">
                            <input wire:model="variationsSelectAll" class="form-check-input" type="checkbox" />
                        </div>
                    </th>
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Активность</th>
                    <th>Детальная картинка</th>
                    <th>Дополнительные фото</th>
                    <th>Сортировка</th>
                    <th>Закупочная цена</th>
                    <th>Упаковка / единица измерения</th>
                    <th>Коэффициент</th>
                    <th>Розничная цена за упаковку</th>
                    <th>Наличие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($variations as $variation)
                    <tr wire:key="{{$variation['id']}}" ondblclick="@this.setCurrentVariation({{$variation['id']}}).then(() => {$('#current-variation').modal('show')})">
                        <td>
                            <div class="form-check form-check-inline">
                                <input wire:model.defer="variations.{{$variation['id']}}.is_checked" class="form-check-input" type="checkbox" />
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary" type="button" id="actions-dropdown-{{$variation['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></button>
                                <div class="dropdown-menu" aria-labelledby="actions-dropdown-{{$variation['id']}}">
                                    <button onclick="@this.setCurrentVariation({{$variation['id']}}).then(() => {$('#current-variation').modal('show')})" type="button" data-target="#current-variation" class="dropdown-item btn btn-link">Изменить</button>
                                    <button type="button" class="dropdown-item btn btn-link" wire:click="toggleVariationActive({{$variation['id']}})">
                                        @if($variation['is_active'])
                                            Деактивировать
                                        @else
                                            Активировать
                                        @endif
                                    </button>
                                    <button wire:click="copyVariation({{$variation['id']}})" type="button" class="btn btn-link">Копировать</button>
                                    <button type="button" class="dropdown-item btn btn-link" onclick="if (confirm('Вы уверены, что хотите удалить вариант товара `{{$variation['id']}}` `{{$variation['name']}}` ?')) {@this.deleteVariation({{$variation['id']}});}">Удалить</button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="javascript:;" onclick="@this.setCurrentVariation({{$variation['id']}}).then(() => {$('#current-variation').modal('show')})" type="button">{{$variation['id']}}</a>
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[id].name"])
                            @else
                                {{$variation['name']}}
                            @endif
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                @include('admin.livewire.includes.form-check', ['field' => "variations.$variation[id].is_active"])
                            @else
                                {{$variation['is_active'] ? 'Да' : 'Нет'}}
                            @endif
                        </td>
                        <td>
                            @if($variation['main_image_media_urls']['xs_thumb'] ?? null)
                                <a href="{{$variation['main_image_media_urls']['url']}}" target="_blank"><img class="img-fluid" src="{{$variation['main_image_media_urls']['xs_thumb']}}" alt=""></a>
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td>
                            @foreach($variation['additional_images_media_urls'] as $additionalImageMediaUrls)
                                <?php /** @var array $additionalImageMediaUrls @see {@link \Domain\Products\DTOs\ProductMediaUrlsDTO} */ ?>
                                <div class="mb-2" style="max-width: 40px">
                                    <a href="{{$additionalImageMediaUrls['url']}}" target="_blank"><img class="img-fluid" src="{{$additionalImageMediaUrls['xs_thumb']}}" alt=""></a>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[id].ordering"])
                            @else
                                {{$variation['ordering']}}
                            @endif
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                <div class="form-row">
                                    <div class="col">
                                        @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[id].price_purchase"])
                                    </div>
                                    <div class="col">
                                        @include('admin.livewire.includes.form-control-select', ['field' => "variations.$variation[id].price_purchase_currency_id", 'options' => $currencies])
                                    </div>
                                </div>
                            @else
                                {{$variation['price_purchase_rub_formatted']}}
                            @endif
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[id].unit"])
                            @else
                                {{$variation['unit']}}
                            @endif
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[id].coefficient"])
                            @else
                                {{$variation['coefficient']}}
                            @endif
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                <div class="form-row">
                                    <div class="col">
                                        @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[id].price_retail"])
                                    </div>
                                    <div class="col">
                                        @include('admin.livewire.includes.form-control-select', ['field' => "variations.$variation[id].price_retail_currency_id", 'options' => $currencies])
                                    </div>
                                </div>
                            @else
                                {{$variation['price_retail_rub_formatted']}}
                            @endif
                        </td>
                        <td>
                            @if($variationsEditMode && $variation['is_checked'])
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-select', ['field' => "variations.$variation[id].availability_status_id", 'options' => $availabilityStatuses])
                                </div>
                            @else
                                {{$variation['availability_status_name']}}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-edit-variations__footer">
            @if(!$variationsEditMode)
                <div class="variants-btn-group" role="group" aria-label="actions">
                    <button wire:click="handleSetVariationsEditMode" aria-label="edit all mode" type="button" class="btn brn-edit"></button>
                    <button onclick="if (confirm('Вы уверены, что хотите удалить отмеченные записи?')) {@this.handleDeleteSelectedVariations();}" aria-label="delete all" type="button" class="btn btn-delete"></button>
                </div>
            @else
                <button wire:click="saveVariations" type="button" class="btn btn-light">Сохранить</button>
                <button wire:click="handleCancelVariationsEditMode" type="button" class="btn btn-light">Отменить</button>
            @endif
        </div>





        <div wire:ignore.self class="modal fade" id="current-variation" tabindex="-1" aria-labelledby="new-variation-label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="new-variation-label">Многовариантные товары
                            @if(!$currentVariation['id'])
                                (добавление)
                            @else
                                {{$currentVariation['name']}} - Редактирование
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="variation-modal" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-toggle="tab" id="variation-elements-tab" href="#variation-elements" role="tab" aria-controls="variation-elements" aria-selected="true">Элемент</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-toggle="tab" id="variation-photos-tab" href="#variation-photos" role="tab" aria-controls="variation-photos" aria-selected="false">Фото</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="variation-modal-tab-content">

                            <div wire:ignore.self class="tab-pane p-3 fade show active" id="variation-elements" role="tabpanel" aria-labelledby="variation-elements-tab">
                                @include('admin.livewire.includes.form-group-checkbox', ['field' => 'currentVariation.is_active', 'label' => 'Активность'])

                                @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.name', 'label' => 'Название'])

                                @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.ordering', 'label' => 'Сортировка'])

                                @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.coefficient', 'label' => 'Коэффициент на единицу расхода и единица расхода'])

                                @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.unit', 'label' => 'Упаковка / Единица'])

                                @include('admin.livewire.includes.form-group-select', ['field' => 'currentVariation.availability_status_id', 'label' => 'Наличие', 'options' => $availabilityStatuses])

                                <div class="form-group row">
                                    <label for="price_purchase" class="col-sm-3 col-form-label">Закупочная цена:</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.price_purchase"])
                                            </div>
                                            <div class="col">
                                                @include('admin.livewire.includes.form-group-select', ['field' => 'currentVariation.price_purchase_currency_id', 'label' => 'Валюта', 'options' => $currencies])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="price_retail" class="col-sm-3 col-form-label">Розничная цена:</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.price_retail"])
                                            </div>
                                            <div class="col">
                                                @include('admin.livewire.includes.form-group-select', ['field' => 'currentVariation.price_retail_currency_id', 'label' => 'Валюта', 'options' => $currencies])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="currentVariation.preview">Описание для анонса</label>
                                    <div class="nav nav-tabs" role="tablist">
                                        <a class="nav-link" id="current-variation-preview-html-tab" data-toggle="tab" href="#current-variation-preview-html" role="tab" aria-controls="current-variation-preview-html" aria-selected="false">HTML</a>
                                        <a class="nav-link active" id="current-variation-preview-editor-tab" data-toggle="tab" href="#current-variation-preview-editor" role="tab" aria-controls="current-variation-preview-editor" aria-selected="true">Визуальный редактор</a>
                                    </div>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade" id="current-variation-preview-html" role="tabpanel" aria-labelledby="current-variation-preview-html-tab" style="height: 600px">
                                            @include('admin.livewire.includes.form-control-textarea', ['field' => 'currentVariation.preview', 'class' => 'h-100'])
                                        </div>
                                        <div class="tab-pane fade show active" id="current-variation-preview-editor" role="tabpanel" aria-labelledby="current-variation-preview-editor-tab">
                                            <textarea id="currentVariation-preview-tinymce"></textarea>
                                            @error('currentVariation.preview') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div wire:ignore.self class="tab-pane p-3 fade" id="variation-photos" role="tabpanel" aria-labelledby="variation-photos-tab">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Основное фото:</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="card text-center col-3">
                                                @if(!empty($currentVariation['main_image']))
                                                    <div class="card-body">
                                                        <a href="{{$currentVariation['main_image']['url']}}" target="_blank"><img class="img-thumbnail" src="{{$currentVariation['main_image']['url']}}" alt=""></a>
                                                        <div class="form-group">
                                                            @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.main_image.name"])
                                                        </div>
                                                        <button wire:click="deleteVariationMainImage" type="button" class="btn btn-outline-danger">x</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tempVariationMainImage">Загрузить основное фото</label>
                                            <input type="file" wire:model="tempVariationMainImage" class="form-control-file @error("tempVariationMainImage") is-invalid @enderror" id="tempVariationMainImage" />
                                            <div wire:loading wire:target="tempVariationMainImage">
                                                <div class="spinner-border" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            @error("tempVariationMainImage") <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Дополнительные фото:</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            @foreach($currentVariation['additional_images'] as $index => $currentVariationAdditionalImage)
                                                <div wire:key="instructions-{{$index}}-{{$currentVariationAdditionalImage['url']}}" class="card text-center col-3">
                                                    <div class="card-body">
                                                        <a href="{{$currentVariationAdditionalImage['url']}}" target="_blank"><img class="img-thumbnail" src="{{$currentVariationAdditionalImage['url']}}" alt=""></a>
                                                        <div class="form-group">
                                                            @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.additional_images.$index.name"])
                                                        </div>
                                                        <button wire:click="deleteVariationAdditionalImage({{$index}})" type="button" class="btn btn-outline-danger">x</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label for="tempVariationAdditionalImage">Добавить дополнительное фото</label>
                                            <input type="file" wire:model="tempVariationAdditionalImage" class="form-control-file @error("tempVariationAdditionalImage") is-invalid @enderror" id="tempVariationAdditionalImage" />
                                            <div wire:loading wire:target="tempVariationAdditionalImage">
                                                <div class="spinner-border" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            @error("tempVariationAdditionalImage") <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="@this.saveCurrentVariation().then(res => {console.log(res); if (res) {$('#current-variation').modal('hide')}})" type="button" class="btn btn-primary">Сохранить</button>
                        <button wire:click="cancelCurrentVariation" type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#current-variation').on('hide.bs.modal', () => {
            @this.cancelCurrentVariation();
        })
    </script>

    <script>
        document.addEventListener('livewire:load', () => {
            jQuery(() => {
                if (typeof livewireTinymce === 'function') livewireTinymce()
            })
        })
        document.addEventListener('livewire:update', () => {
            if (typeof livewireTinymce === 'function') livewireTinymce()
        })
    </script>
@endif
