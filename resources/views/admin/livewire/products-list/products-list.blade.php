<?php
/**
 * @var array[] $items @see {@link \Domain\Products\DTOs\Admin\ProductItemDTO[]}
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 * @var string|int|null $brand_id
 * @var string|int|null $brand_name
 * @var string|int $total
 * @var array[] $per_page_options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
 * @var bool $editMode
 * @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 * @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\AvailabilityStatus}
 * @var \App\Http\Livewire\Admin\ProductsList $this
 */
?>
<div>
    @include('admin.livewire.includes.form-search', [
        'submit' => 'handleSearch',
        'newRoute' => route('admin.products.create'),
        'clearAll' => 'clearAllFilters',
        'prepends' => $this->getPrepends(),
        'brandFilter' => true,
    ])

    <div class="admin-edit-variations">
        <div wire:loading.flex>
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">
                    <div class="form-check form-check-inline">
                        <input wire:model="selectAll" @if($editMode) disabled @endif class="form-check-input position-static" type="checkbox">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                <th scope="col">ID</th>
                <th scope="col">Сортировка</th>
                <th scope="col">Название</th>
                <th scope="col">Активность</th>
                <th scope="col">Упаковка</th>
                <th scope="col">Закупочная</th>
                <th scope="col">Розничная</th>
                <th scope="col">Служебная Информация</th>
                <th scope="col">Наличие</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $product)
                <tr class="js-product-item" wire:key="product-{{$product['uuid']}}">
                    <td>
                        <div class="form-check">
                            <input wire:model.defer="items.{{$product['uuid']}}.is_checked" @if($editMode) disabled @endif class="form-check-input position-static" type="checkbox">
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn__grid-row-action-button" type="button" id="actions-dropdown-{{$product['uuid']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu bx-core-popup-menu" aria-labelledby="actions-dropdown-{{$product['uuid']}}">
                                <div class="bx-core-popup-menu__arrow"></div>
                                <a class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" href="{{route("admin.products.edit", $product['id'])}}">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                    <span class="bx-core-popup-menu-item-text">Изменить</span>
                                </a>
                                <button type="button" class="bx-core-popup-menu-item" wire:click="toggleActive({{$product['id']}})">
                                    <span class="bx-core-popup-menu-item-icon"></span>
                                    <span class="bx-core-popup-menu-item-text">
                                        @if($product['is_active'])
                                            Деактивировать
                                        @else
                                            Активировать
                                        @endif
                                    </span>
                                </button>
                                <span class="bx-core-popup-menu-separator"></span>
                                <a class="bx-core-popup-menu-item" href="{{route(\App\Constants::ROUTE_ADMIN_PRODUCTS_CREATE, ['copy_id' => $product['id']])}}">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                    <span class="bx-core-popup-menu-item-text">Копировать</span>
                                </a>
                                <span class="bx-core-popup-menu-separator"></span>
                                <button type="button" class="bx-core-popup-menu-item" onclick="if (confirm('Вы уверены, что хотите удалить продукт `{{$product['id']}}` `{{$product['name']}}` ?')) {@this.handleDelete({{$product['id']}});}">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                    <span class="bx-core-popup-menu-item-text">Удалить</span>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td><span class="main-grid-cell-content">{{$product['id']}}</span></td>
                    <td @if($editMode && $product['is_checked']) style="width: 200px;" @endif>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.ordering"])
                        @else
                            <span class="main-grid-cell-content">{{$product['ordering']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.name"])
                        @else
                            <span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product['id'])}}">{{$product['name']}}</a></span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-check', ['field' => "items.{$product['uuid']}.is_active"])
                        @else
                            <span class="main-grid-cell-content">{{$product['is_active_name']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.unit"])
                        @else
                            <span class="main-grid-cell-content">{{$product['unit']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            <div class="form-row">
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.price_purchase"])
                                </div>
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.price_purchase_currency_id", 'options' => $currencies])
                                </div>
                            </div>
                        @else
                            <span class="main-grid-cell-content">{{$product['price_purchase_formatted']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            <div class="form-row">
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.price_retail"])
                                </div>
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.price_retail_currency_id", 'options' => $currencies])
                                </div>
                            </div>
                        @else
                            <span class="main-grid-cell-content">{{$product['price_retail_formatted']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-textarea', ['field' => "items.{$product['uuid']}.admin_comment"])
                        @else
                            <span class="main-grid-cell-content">{{$product['admin_comment']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.availability_status_id", 'options' => $availabilityStatuses])
                        @else
                            <span class="main-grid-cell-content">{{$product['availability_status_name']}}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @include(
        'admin.livewire.includes.pagination',
         array_merge([
             'options' => $per_page_options,
             'wire' => ['change' => 'handleSearch']
         ], compact('paginator', 'total'))
    )

    <div class="row pb-5">
        @if(!$editMode)
            <div class="col-sm-3" wire:key="edit-btn">
                <button wire:click.prevent="$set('editMode', true)" type="button" class="btn btn-light"><i class="fa fa-edit"></i> Редактировать</button>
            </div>
            <div class="col-sm-3" wire:key="delete-btn">
                <button onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) {@this.deleteSelected()}" type="button" class="btn btn-light"><i class="fa fa-times"></i> Удалить</button>
            </div>
        @else
            <div class="col-sm-3" wire:key="save-btn">
                <button wire:click.prevent="saveSelected" type="button" class="btn btn-info">Сохранить</button>
            </div>
            <div class="col-sm-3" wire:key="cancel-btn">
                <button wire:click.prevent="cancelEdit" type="button" class="btn btn-warning">Отменить</button>
            </div>
        @endif
    </div>
</div>
