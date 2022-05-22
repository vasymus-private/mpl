<?php
/**
 * @var \App\Http\Livewire\Admin\ShowProduct\ShowProduct $this
 * @var array[] $variations @see {@link \Domain\Products\DTOs\Admin\VariationDTO}
 * @var array $currentVariation @see {@link \Domain\Products\DTOs\Admin\VariationDTO}
 * @var bool $variationsEditMode
 * @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 * @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 * @var \Domain\Common\Enums\Column[] $sortableColumns
 */
?>
<div class="admin-edit-variations">
    <div class="admin-edit-variations__header">
        @if($this->isCreatingFromCopy)
            <p class="text-danger">Чтобы добавлять или редактировать новые варианты, необходимо сохранить скопированный товар.</p>
        @else
            <button onclick="@this.setCurrentVariation().then(() => {$('#current-variation').modal('show')})" type="button" data-target="#current-variation" class="btn btn__add">Добавить элемент</button>
            <button type="button" data-toggle="modal" data-target="#customize-list" class="btn btn-primary mb-2 mr-2">Настроить</button>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" style="width: 3000px;">
            <thead>
            <tr>
                <th>
                    <div class="form-check form-check-inline">
                        <input
                            wire:model="variationsSelectAll"
                            @if($this->isCreatingFromCopy) disabled @endif
                            class="form-check-input"
                            type="checkbox"
                        />
                    </div>
                </th>
                <th>&nbsp;</th>
                @foreach($sortableColumns as $sortableColumn)
                    <th wire:key="sortable-column-table-header-{{$sortableColumn->value}}" scope="col">{{$sortableColumn->label}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($variations as $variation)
                <tr wire:key="{{$variation['uuid']}}" ondblclick="@this.setCurrentVariation('{{$variation['uuid']}}').then(() => {$('#current-variation').modal('show')})">
                    <td>
                        <div class="form-check form-check-inline">
                            <input
                                wire:model.defer="variations.{{$variation['uuid']}}.is_checked"
                                @if($this->isCreatingFromCopy) disabled @endif
                                class="form-check-input"
                                type="checkbox"
                            />
                        </div>
                    </td>
                    <td>
                        @if($this->isCreatingFromCopy)
                            &nbsp;
                        @else
                            <div class="dropdown">
                                <button class="btn btn__grid-row-action-button" type="button" id="actions-dropdown-{{$variation['uuid']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu bx-core-popup-menu" aria-labelledby="actions-dropdown-{{$variation['uuid']}}">
                                    <div class="bx-core-popup-menu__arrow"></div>
                                    <button onclick="@this.setCurrentVariation('{{$variation['uuid']}}').then(() => {$('#current-variation').modal('show')})" type="button" data-target="#current-variation" class="bx-core-popup-menu-item bx-core-popup-menu-item-default">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Изменить</span>
                                    </button>
                                    <button type="button" class="bx-core-popup-menu-item" wire:click="toggleVariationActive('{{$variation['uuid']}}')">
                                        <span class="bx-core-popup-menu-item-icon"></span>
                                        <span class="bx-core-popup-menu-item-text">
                                            @if($variation['is_active'])
                                                Деактивировать
                                            @else
                                                Активировать
                                            @endif
                                        </span>
                                    </button>
                                    <button wire:click="copyVariation('{{$variation['uuid']}}')" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon"></span>
                                        <span class="bx-core-popup-menu-item-text">Копировать</span>
                                    </button>
                                    <button type="button" class="bx-core-popup-menu-item" onclick="if (confirm('Вы уверены, что хотите удалить вариант товара `{{$variation['id']}}` `{{$variation['name']}}` ?')) {@this.deleteVariation('{{$variation['uuid']}}');}">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </td>

                    @foreach($sortableColumns as $sortableColumn)
                        @switch(true)
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::id()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    <a href="javascript:;" onclick="@this.setCurrentVariation('{{$variation['uuid']}}').then(() => {$('#current-variation').modal('show')})" type="button">{{$variation['id']}}</a>
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::name()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[uuid].name"])
                                    @else
                                        {{$variation['name']}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::active()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        @include('admin.livewire.includes.form-check', ['field' => "variations.$variation[uuid].is_active"])
                                    @else
                                        {{$variation['is_active'] ? 'Да' : 'Нет'}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::detailed_image()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variation['main_image_media_urls']['xs_thumb'] ?? null)
                                        <a href="{{$variation['main_image_media_urls']['url']}}" target="_blank"><img class="img-fluid" src="{{$variation['main_image_media_urls']['xs_thumb']}}" alt=""></a>
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::additional_images()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @foreach($variation['additional_images_media_urls'] as $additionalImageMediaUrls)
                                        <?php /** @var array $additionalImageMediaUrls @see {@link \Domain\Products\DTOs\ProductMediaUrlsDTO} */ ?>
                                        <div class="mb-2" style="max-width: 40px">
                                            <a href="{{$additionalImageMediaUrls['url']}}" target="_blank"><img class="img-fluid" src="{{$additionalImageMediaUrls['xs_thumb']}}" alt=""></a>
                                        </div>
                                    @endforeach
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::ordering()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[uuid].ordering"])
                                    @else
                                        {{$variation['ordering']}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::price_purchase()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        <div class="form-row">
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[uuid].price_purchase"])
                                            </div>
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-select', ['field' => "variations.$variation[uuid].price_purchase_currency_id", 'options' => $currencies])
                                            </div>
                                        </div>
                                    @else
                                        {{$variation['price_purchase_rub_formatted']}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::unit()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[uuid].unit"])
                                    @else
                                        {{$variation['unit']}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::coefficient()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[uuid].coefficient"])
                                    @else
                                        {{$variation['coefficient']}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::coefficient_description()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[uuid].coefficient_description"])
                                    @else
                                        {{$variation['coefficient_description']}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::price_retail()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        <div class="form-row">
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-input', ['field' => "variations.$variation[uuid].price_retail"])
                                            </div>
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-select', ['field' => "variations.$variation[uuid].price_retail_currency_id", 'options' => $currencies])
                                            </div>
                                        </div>
                                    @else
                                        {{$variation['price_retail_rub_formatted']}}
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::availability()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                    @if($variationsEditMode && $variation['is_checked'])
                                        <div class="col">
                                            @include('admin.livewire.includes.form-control-select', ['field' => "variations.$variation[uuid].availability_status_id", 'options' => $availabilityStatuses])
                                        </div>
                                    @else
                                        {{$variation['availability_status_name']}}
                                    @endif
                                </td>
                                @break
                        @endswitch
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if(!$this->isCreatingFromCopy)
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
                                <div class="item-edit product-edit">
                                    @include('admin.livewire.includes.form-group-checkbox', ['field' => 'currentVariation.is_active', 'label' => 'Активность'])

                                    @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.name', 'label' => 'Название', 'labelClass' => 'font-weight-bold'])

                                    @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.ordering', 'label' => 'Сортировка', 'className' => 'width-15'])

                                    @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.coefficient', 'label' => 'Коэффициент на единицу расхода и единица расхода', 'className' => 'width-27'])

                                    @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.coefficient_description', 'className' => 'width-27', 'label' => 'Описание коэффициента'])

                                    @include('admin.livewire.includes.form-group-input', ['field' => 'currentVariation.unit', 'label' => 'Упаковка / Единица', 'className' => 'width-15'])

                                    @include('admin.livewire.includes.form-group-select', ['field' => 'currentVariation.availability_status_id', 'label' => 'Наличие', 'options' => $availabilityStatuses, 'className' => 'width-27'])

                                    <div class="form-group row">
                                        <label for="price_purchase" class="col-sm-5 col-form-label font-weight-bold">Закупочная цена:</label>
                                        <div class="col-sm-7 d-flex align-items-center">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.price_purchase", 'className' => 'width-27'])
                                                </div>
                                                <div class="col-sm-6">
                                                    @include('admin.livewire.includes.form-group-select', ['field' => 'currentVariation.price_purchase_currency_id', 'label' => 'Валюта', 'options' => $currencies])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="price_retail" class="col-sm-5 col-form-label font-weight-bold">Розничная цена:</label>
                                        <div class="col-sm-7 d-flex align-items-center">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.price_retail"])
                                                </div>
                                                <div class="col-sm-6">
                                                    @include('admin.livewire.includes.form-group-select', ['field' => 'currentVariation.price_retail_currency_id', 'label' => 'Валюта', 'options' => $currencies])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="mb-4" for="currentVariation.preview">Описание для анонса</label>
                                        <div class="nav nav-tabs" role="tablist">
                                            <a class="nav-link" id="current-variation-preview-html-tab" data-toggle="tab" href="#current-variation-preview-html" role="tab" aria-controls="current-variation-preview-html" aria-selected="false">HTML</a>
                                            <a class="nav-link active" id="current-variation-preview-editor-tab" data-toggle="tab" href="#current-variation-preview-editor" role="tab" aria-controls="current-variation-preview-editor" aria-selected="true">Визуальный редактор</a>
                                        </div>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade" id="current-variation-preview-html" role="tabpanel" aria-labelledby="current-variation-preview-html-tab" style="height: 600px">
                                                @include('admin.livewire.includes.form-control-textarea', ['field' => 'currentVariation.preview', 'class' => 'h-100'])
                                            </div>
                                            <div class="tab-pane fade show active" id="current-variation-preview-editor" role="tabpanel" aria-labelledby="current-variation-preview-editor-tab">
                                                <textarea id="currentVariation-preview-tinymce" rows="10" cols="80"></textarea>
                                                @error('currentVariation.preview') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane p-3 fade" id="variation-photos" role="tabpanel" aria-labelledby="variation-photos-tab">
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">Основное фото:</label>
                                    <div class="col-sm-6">
                                        <div class="add-file">
                                            <div class="row">
                                                <div class="card text-center col-6">
                                                    @if(!empty($currentVariation['main_image']))
                                                        <a href="{{$currentVariation['main_image']['url']}}" target="_blank"><img class="img-thumbnail" src="{{$currentVariation['main_image']['url']}}" alt=""></a>
                                                        <div class="form-group">
                                                            @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.main_image.name"])
                                                        </div>
                                                        <button wire:click="deleteVariationMainImage" type="button" class="adm-fileinput-item-preview__remove">x</button>
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">Дополнительные фото:</label>
                                    <div class="col-sm-6">
                                        <div class="add-file">
                                            <div class="row">
                                                @foreach($currentVariation['additional_images'] as $index => $currentVariationAdditionalImage)
                                                    <div wire:key="instructions-{{$index}}-{{$currentVariationAdditionalImage['url']}}" class="card text-center">
                                                        <a href="{{$currentVariationAdditionalImage['url']}}" target="_blank"><img class="img-thumbnail" src="{{$currentVariationAdditionalImage['url']}}" alt=""></a>
                                                        <div class="form-group">
                                                            @include('admin.livewire.includes.form-control-input', ['field' => "currentVariation.additional_images.$index.name"])
                                                        </div>
                                                        <button wire:click="deleteVariationAdditionalImage({{$index}})" type="button" class="btn btn-outline-danger">x</button>
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
                    </div>
                    <div class="modal-footer">
                        <button onclick="@this.saveCurrentVariation().then(res => {console.log(res); if (res) {$('#current-variation').modal('hide')}})" type="button" class="btn btn-primary mb-2 btn__save mr-2">Сохранить</button>
                        <button wire:click="cancelCurrentVariation" type="button" class="btn btn-info mb-2 btn__default" data-dismiss="modal">Отменить</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modals -->
<div wire:ignore.self class="modal fade" id="customize-list" tabindex="-1" aria-labelledby="customize-list-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div wire:loading.flex wire:target="handleCustomizeSortableList, handleDefaultSortableList">
                <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="customize-list-title">Настройка списка</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <ul id="product-variant-columns-sortable" class="list-group list-group-flush">
                        @foreach($sortableColumns as $sortableColumn)
                            <li wire:key="sortable-column-modal-list-{{$sortableColumn->value}}" style="cursor:grab;" class="list-group-item" data-value="{{$sortableColumn->value}}">{{$sortableColumn->label}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    onclick="@this.handleCustomizeSortableList(getColumnsSorted('product-variant-columns-sortable')).then((res) => { if(res) $('#customize-list').modal('hide') })"
                    type="button"
                    class="btn btn-primary"
                >Сохранить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button onclick="@this.handleDefaultSortableList().then((res) => { if(res) $('#customize-list').modal('hide') })" type="button" class="btn btn-secondary">Сбросить</button>
            </div>
        </div>
    </div>
</div>

@if(!$this->isCreatingFromCopy)
    <script>
        $('#current-variation').on('hide.bs.modal', () => {
            @this.cancelCurrentVariation();
        })
    </script>

    <script>
        document.addEventListener('livewire:load', () => {
            jQuery(() => {
                if (typeof livewireCkeditor4 === 'function') livewireCkeditor4()
            })
        })
        document.addEventListener('livewire:update', () => {
            if (typeof livewireCkeditor4 === 'function') livewireCkeditor4()
        })
    </script>
@endif
