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
 * @var \Domain\Products\Enums\ProductAdminColumn[] $productAdminColumns
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

    <div>
        <button type="button" data-toggle="modal" data-target="#customize-product-list" class="btn btn-primary mb-2 mr-2">Настроить</button>
    </div>

    <div class="admin-edit-variations table-responsive">
        <div wire:loading.flex>
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover" style="width: 2000px;">
            <thead>
            <tr>
                <th scope="col">
                    <div class="form-check form-check-inline">
                        <input wire:model="selectAll" @if($editMode) disabled @endif class="form-check-input position-static" type="checkbox">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                @foreach($productAdminColumns as $productAdminColumn)
                    <th scope="col">{{$productAdminColumn->label}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($items as $product)
                <tr class="js-product-item" wire:key="product-{{$product['uuid']}}" ondblclick="location.href=`{{route("admin.products.edit", $product['id'])}}`">
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

                    @foreach($productAdminColumns as $productAdminColumn)
                        @switch(true)
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::ordering()))
                                <td @if($editMode && $product['is_checked']) style="width: 200px;" @endif>
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.ordering"])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['ordering']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::name()))
                                <td>
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.name"])
                                    @else
                                        <span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product['id'])}}">{{$product['name']}}</a></span>
                                    @endif
                                </td>
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::active()))
                                <td>
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-check', ['field' => "items.{$product['uuid']}.is_active"])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['is_active_name']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::unit()))
                                <td>
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.unit"])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['unit']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::price_purchase()))
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
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::price_retail()))
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
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::admin_comment()))
                                <td>
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-textarea', ['field' => "items.{$product['uuid']}.admin_comment"])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['admin_comment']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::availability()))
                                <td>
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.availability_status_id", 'options' => $availabilityStatuses])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['availability_status_name']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($productAdminColumn->equals(\Domain\Products\Enums\ProductAdminColumn::id()))
                                <td>
                                    <span class="main-grid-cell-content">{{$product['id']}}</span>
                                </td>
                                @break
                        @endswitch
                    @endforeach
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

    <footer class="footer edit-item-footer">
        @if(!$editMode)
            <button wire:click.prevent="$set('editMode', true)" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
            <button onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) {@this.deleteSelected()}" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
        @else
            <button wire:click.prevent="saveSelected" type="button" class="btn btn-info">Сохранить</button>
            <button wire:click.prevent="cancelEdit" type="button" class="btn btn-warning">Отменить</button>
        @endif
    </footer>
    <!-- Modals -->
    <div wire:ignore.self class="modal fade" id="customize-product-list" tabindex="-1" aria-labelledby="customize-product-list-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div wire:loading.flex wire:target="handleCustomizeOrderList, handleDefaultOrderList">
                    <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="customize-product-list-title">Настройка списка</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <ul id="product-columns-sortable" class="list-group list-group-flush">
                            @foreach($productAdminColumns as $productAdminColumn)
                                <li style="cursor:grab;" class="list-group-item" data-value="{{$productAdminColumn->value}}">{{$productAdminColumn->label}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        onclick="@this.handleCustomizeProductList(getProductColumnsSortable()).then((res) => { if(res) $('#customize-product-list').modal('hide') })"
                        type="button"
                        class="btn btn-primary"
                    >Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button onclick="@this.handleDefaultProductList().then((res) => { if(res) $('#customize-product-list').modal('hide') })" type="button" class="btn btn-secondary">Сбросить</button>
                </div>
            </div>
        </div>
    </div>
</div>
