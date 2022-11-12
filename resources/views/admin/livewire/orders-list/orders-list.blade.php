<?php
/**
 * @var \App\Http\Livewire\Admin\OrdersList $this
 * @var array[] $items @see {@link \Domain\Products\DTOs\Admin\OrderItemDTO}
 * @var array[] $per_page_options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var array[] $managers @see {@link \Domain\Common\DTOs\OptionDTO}
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
    <form wire:submit.prevent="handleSearch" class="filter-form">
        <div class="filter-form__body">
            <div class="form-group row">
                <label for="item.slug" class="col-sm-2 col-form-label">Дата с:</label>
                <div class="col-sm-4">
                    <div class="input-group @error('date_from') is-invalid @enderror">
                        <input wire:model.defer="date_from" type="date" class="form-control @error('date_from') is-invalid @enderror" id="date_from">
                    </div>
                    @error('date_from') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <label for="item.slug" class="col-sm-2 col-form-label">Дата по:</label>
                <div class="col-sm-4">
                    <div class="input-group @error('date_to') is-invalid @enderror">
                        <input wire:model.defer="date_to" type="date" class="form-control @error('date_to') is-invalid @enderror" id="date_to">
                    </div>
                    @error('date_to') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            @include('admin.livewire.includes.form-group-input', ['field' => 'order_id', 'label' => 'Номер заказа'])

            @include('admin.livewire.includes.form-group-input', ['field' => 'email', 'label' => 'Емейл'])

            @include('admin.livewire.includes.form-group-input', ['field' => 'name', 'label' => 'Имя'])

            @include('admin.livewire.includes.form-group-select', ['field' => 'admin_id', 'label' => 'Менеджер', 'options' => $managers])

        </div>
        <div class="filter-form__footer">
            <button type="submit" class="btn btn-primary mb-2 btn__default mr-2">Найти</button>
            <button wire:click="clearFilters" type="button" class="btn btn-primary mb-2 btn__default mr-2">Отменить</button>
        </div>
    </form>

    <div>
        <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_CREATE)}}" class="btn btn-primary mb-2 btn__save mr-2">Добавить заказ</a>

        <button type="button" data-toggle="modal" data-target="#customize-list" class="btn btn-primary mb-2 mr-2">Настроить</button>
    </div>

    <div class="admin-edit-variations table-responsive">
        <div wire:loading.flex>
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover js-order-busy-marker-wrapper" style="width: 2000px;">
            <thead>
            <tr>
                <th scope="col">
                    <div class="form-check form-check-inline">
                        <input
                            x-bind:disabled="editMode"
                            x-model="selectAll"
                            class="form-check-input position-static"
                            type="checkbox">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                @foreach($sortableColumns as $sortableColumn)
                    <th wire:key="sortable-column-table-header-{{$sortableColumn->value}}" scope="col">{{$sortableColumn->label}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
                @foreach($items as $order)
                    <tr wire:key="order-{{$order['id']}}-{{json_encode($sortableColumns)}}">
                        <td
                            data-item-id="{{$order['id']}}"
                            @click="
                                if(!editMode && items[$el.dataset['itemId']]) {
                                    let isChecked = items[$el.dataset['itemId']].is_checked;
                                    items[$el.dataset['itemId']].is_checked = !isChecked;
                                    $el.querySelector('input').checked = !isChecked;
                                }
                            ">
                            <div class="form-check">
                                <input
                                    data-item-id="{{$order['id']}}"
                                    @click.stop="$el.closest('td').click()"
                                    x-bind:disabled="editMode"
                                    class="form-check-input position-static js-product-item-checkbox"
                                    type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn__grid-row-action-button" type="button" id="actions-dropdown-{{$order['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu bx-core-popup-menu" aria-labelledby="actions-dropdown-{{$order['id']}}">
                                    <div class="bx-core-popup-menu__arrow"></div>
                                    <a class="bx-core-popup-menu-item bx-core-popup-menu-item-default" href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_EDIT, $order['id'])}}">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Изменить</span>
                                    </a>
                                    <a class="bx-core-popup-menu-item" href="#">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                        <span class="bx-core-popup-menu-item-text">Копировать</span>
                                    </a>
                                    <button type="button" class="bx-core-popup-menu-item" onclick="if (confirm('Вы уверены, что хотите удалить заказ `{{$order['id']}}`?')) {@this.handleDelete({{$order['id']}});}">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        </td>

                        @foreach($sortableColumns as $sortableColumn)
                            @switch(true)
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::date_creation()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['date']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::id()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">
                                            <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_EDIT, $order['id'])}}" style="white-space: nowrap;">
                                                <span class="js-order-busy-marker js-order-busy-marker-{{$order['id']}}" data-id="{{$order['id']}}">
                                                    @if($order['is_busy_by_other_admin'])
                                                        <span style="display: inline-block; width: 20px; height: 20px; background-color: red; border-radius: 100%;"></span>
                                                    @else
                                                        <span style="display: inline-block; width: 20px; height: 20px; background-color: green; border-radius: 100%;"></span>
                                                    @endif
                                                </span>
                                                №{{$order['id']}}
                                            </a>
                                        </span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::status()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}" @if($order['order_status_color']) style="background-color: {{$order['order_status_color']}};" @endif>
                                        <span class="main-grid-cell-content">{{$order['order_status_name']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::positions()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <div class="main-grid-cell-content">
                                            <?php /** @var array $orderProductItem @see {@link \Domain\Products\DTOs\Admin\OrderItemProductItemDTO} */ ?>
                                            @foreach($order['products'] as $orderProductItem)
                                                <p>
                                                    {{$orderProductItem['name']}} <br>
                                                    ({{$orderProductItem['count']}} шт.)
                                                </p>
                                            @endforeach
                                        </div>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::comment_admin()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['comment_admin']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::importance()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}" @if($order['importance_color']) style="background-color: {{$order['importance_color']}};" @endif>
                                        <span class="main-grid-cell-content">{{$order['importance_name']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::manager()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        @if($order['admin_id'])
                                            <span class="main-grid-cell-content">
                                                <span style="border: 1px solid black; padding: 3px 6px; border-radius: 3px; width: 50px; display: inline-block; text-align: center; background-color: {{$order['admin_color'] ?: 'transparent'}};">
                                                    {{$order['admin_name']}}
                                                </span>
                                            </span>
                                        @endif
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::sum()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['order_price_retail_rub_formatted']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::name()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['user_name']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::phone()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['user_phone']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::email()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['user_email']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::comment_user()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['comment_user']}}</span>
                                    </td>
                                    @break
                                @case($sortableColumn->equals(\Domain\Common\Enums\Column::payment_method()))
                                    <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}">
                                        <span class="main-grid-cell-content">{{$order['payment_method_name']}}</span>
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

    <div class="row pb-5">
        <div class="col-sm-3" wire:key="delete-btn">
            <button
                x-bind:disabled="!Object.values(items).some(item => item.is_checked)"
                onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные заказы?')) {@this.deleteSelected()}"
                type="button"
                class="btn btn-light">
                <i class="fa fa-times"></i> Удалить
            </button>
        </div>
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
                        <ul id="order-columns-sortable" class="list-group list-group-flush">
                            @foreach($sortableColumns as $sortableColumn)
                                <li wire:key="sortable-column-modal-list-{{$sortableColumn->value}}" style="cursor:grab;" class="list-group-item" data-value="{{$sortableColumn->value}}">{{$sortableColumn->label}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        onclick="@this.handleCustomizeSortableList(getColumnsSorted('order-columns-sortable')).then((res) => { if(res) $('#customize-list').modal('hide') })"
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
