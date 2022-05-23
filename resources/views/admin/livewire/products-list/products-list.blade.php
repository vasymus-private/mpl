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
 * @var \Domain\Common\Enums\Column[] $sortableColumns
 */
?>
<div x-data="{
        items: @entangle('items').defer,
        editMode: @entangle('editMode'),
        selectAll: @entangle('selectAll')
    }"
     x-init="
        Livewire.hook('message.processed', (message, component) => {
            [...$el.querySelectorAll('.js-product-item-checkbox')].forEach(e => {
                let uuid = e.dataset['itemId'];
                let item = component.$wire.items[uuid];
                if (item) {
                    e.checked = item.is_checked;
                }
            })
        })
    ">
    @include('admin.livewire.includes.form-search', [
        'submit' => 'handleSearch',
        'newRoute' => route('admin.products.create'),
        'clearAll' => 'clearAllFilters',
        'prepends' => $this->getPrepends(),
        'brandFilter' => true,
    ])

    <div>
        <button type="button" data-toggle="modal" data-target="#customize-list" class="btn btn-primary mb-2 mr-2">Настроить</button>
    </div>

    <div>{{json_encode($sortableColumns)}}</div>

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
                    <th wire:key="sortable-column-table-header-checkbox" scope="col">
                        <div class="form-check form-check-inline">
                            <input
                                x-bind:disabled="editMode"
                                x-model="selectAll"
                                class="form-check-input position-static"
                                type="checkbox">
                        </div>
                    </th>
                    <th wire:key="sortable-column-table-header-dropdown" scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                    @foreach($sortableColumns as $sortableColumn)
                        <th wire:key="sortable-column-table-header-{{$sortableColumn->value}}" scope="col">{{$sortableColumn->label}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($items as $product)
                <tr class="js-product-item" wire:key="product-{{$product['uuid']}}">
                    <td
                        wire:key="sortable-column-table-row-checkbox"
                        data-item-id="{{$product['uuid']}}"
                        @click="
                            if(!editMode && items[$el.dataset['itemId']]) {
                                let isChecked = items[$el.dataset['itemId']].is_checked;
                                items[$el.dataset['itemId']].is_checked = !isChecked;
                                $el.querySelector('input').checked = !isChecked;
                            }
                        ">
                        <div class="form-check">
                            <input
                                data-item-id="{{$product['uuid']}}"
                                @click.stop="$el.closest('td').click()"
                                x-bind:disabled="editMode"
                                class="form-check-input position-static js-product-item-checkbox"
                                type="checkbox">
                        </div>
                    </td>
                    <td wire:key="sortable-column-table-row-dropdown">
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

                    @foreach($sortableColumns as $sortableColumn)
                        @switch(true)
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::ordering()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}" @if($editMode && $product['is_checked']) style="width: 200px;" @endif>
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.ordering", 'modifier' => '.defer'])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['ordering']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::name()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.name", 'modifier' => '.defer'])
                                    @else
                                        <span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product['id'])}}">{{$product['name']}}</a></span>
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::active()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-check', ['field' => "items.{$product['uuid']}.is_active", 'modifier' => '.defer'])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['is_active_name']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::unit()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.unit", 'modifier' => '.defer'])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['unit']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::price_purchase()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                                    @if($editMode && $product['is_checked'])
                                        <div class="form-row">
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.price_purchase", 'modifier' => '.defer'])
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
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::price_retail()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                                    @if($editMode && $product['is_checked'])
                                        <div class="form-row">
                                            <div class="col">
                                                @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.price_retail", 'modifier' => '.defer'])
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
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::admin_comment()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-textarea', ['field' => "items.{$product['uuid']}.admin_comment", 'modifier' => '.defer'])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['admin_comment']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::availability()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                                    @if($editMode && $product['is_checked'])
                                        @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.availability_status_id", 'options' => $availabilityStatuses])
                                    @else
                                        <span class="main-grid-cell-content">{{$product['availability_status_name']}}</span>
                                    @endif
                                </td>
                                @break
                            @case($sortableColumn->equals(\Domain\Common\Enums\Column::id()))
                                <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
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
            <button
                wire:click.prevent="$set('editMode', true)"
                x-bind:disabled="!Object.values(items).some(item => item.is_checked)"
                type="button"
                class="btn btn-primary mb-2 btn__save mr-2">
                Редактировать
            </button>
            <button
                x-bind:disabled="!Object.values(items).some(item => item.is_checked)"
                onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) {@this.deleteSelected()}"
                type="button"
                class="btn btn-info mb-2 btn__default">
                Удалить
            </button>
        @else
            <button wire:click.prevent="saveSelected" type="button" class="btn btn-info">Сохранить</button>
            <button @click="$wire.cancelEdit()" type="button" class="btn btn-warning">Отменить</button>
        @endif
    </footer>

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
                        <ul id="product-columns-sortable" class="list-group list-group-flush">
                            @foreach($sortableColumns as $sortableColumn)
                                <li wire:key="sortable-column-modal-list-{{$sortableColumn->value}}" style="cursor:grab;" class="list-group-item" data-value="{{$sortableColumn->value}}">{{$sortableColumn->label}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        onclick="@this.handleCustomizeSortableList(getColumnsSorted('product-columns-sortable')).then((res) => { if(res) $('#customize-list').modal('hide') })"
                        type="button"
                        class="btn btn-primary"
                    >Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button onclick="@this.handleDefaultSortableList().then((res) => { if(res) $('#customize-list').modal('hide') })" type="button" class="btn btn-secondary">Сбросить</button>
                </div>
            </div>
        </div>
    </div>
</div>
