<?php
/**
 * @var \App\Http\Livewire\Admin\OrdersList $this
 * @var array[] $items @see {@link \Domain\Products\DTOs\Admin\OrderItemDTO}
 * @var array[] $per_page_options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var array[] $managers @see {@link \Domain\Common\DTOs\OptionDTO}
 */
?>
<div>
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
    </div>

    <div class="admin-edit-variations table-responsive">
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
                        <input wire:model="selectAll" class="form-check-input position-static" type="checkbox">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                <th scope="col">Дата создания</th>
                <th scope="col">ID</th>
                <th scope="col">Статус</th>
                <th scope="col">Комментарии</th>
                <th scope="col">Комментарий покупателя</th>
                <th scope="col">Важность</th>
                <th scope="col">Менеджер</th>
                <th scope="col">Сумма</th>
                <th scope="col">Имя</th>
                <th scope="col">Телефон</th>
                <th scope="col">Email</th>
                <th scope="col"><span style="width: 300px;">Позиции</span></th>
                <th scope="col">Платежная система</th>
            </tr>
            </thead>
            <tbody>
                @foreach($items as $order)
                    <tr wire:key="product-{{$order['id']}}" ondblclick="location.href=`{{route(\App\Constants::ROUTE_ADMIN_ORDERS_EDIT, $order['id'])}}`">
                        <td>
                            <div class="form-check">
                                <input wire:model.defer="items.{{$order['id']}}.is_checked" class="form-check-input position-static" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary" type="button" id="actions-dropdown-{{$order['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></button>
                                <div class="dropdown-menu" aria-labelledby="actions-dropdown-{{$order['id']}}">
                                    <a class="dropdown-item" href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_EDIT, $order['id'])}}">Изменить</a>
                                    <a class="dropdown-item" href="#">Копировать</a>
                                    <button type="button" class="dropdown-item btn btn-link" onclick="if (confirm('Вы уверены, что хотите удалить заказ `{{$order['id']}}`?')) {@this.handleDelete({{$order['id']}});}">Удалить</button>
                                </div>
                            </div>
                        </td>
                        <td><span class="main-grid-cell-content">{{$order['date']}}</span></td>
                        <td><span class="main-grid-cell-content"><a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_EDIT, $order['id'])}}">№{{$order['id']}}</a></span></td>
                        <td @if($order['order_status_color']) style="background-color: {{$order['order_status_color']}};" @endif><span class="main-grid-cell-content">{{$order['order_status_name']}}</span></td>
                        <td><span class="main-grid-cell-content">{{$order['comment_admin']}}</span></td>
                        <td><span class="main-grid-cell-content">{{$order['comment_user']}}</span></td>
                        <td @if($order['importance_color']) style="background-color: {{$order['importance_color']}};" @endif><span class="main-grid-cell-content">{{$order['importance_name']}}</span></td>
                        <td>
                            @if($order['admin_id'])
                                <span class="main-grid-cell-content">
                                    <span style="border: 1px solid black; padding: 3px 6px; border-radius: 3px; width: 50px; display: inline-block; text-align: center; background-color: {{$order['admin_color'] ?: 'transparent'}};">
                                        {{$order['admin_name']}}
                                    </span>
                                </span>
                            @endif
                        </td>
                        <td><span class="main-grid-cell-content">{{$order['order_price_retail_rub_formatted']}}</span></td>
                        <td><span class="main-grid-cell-content">{{$order['user_name']}}</span></td>
                        <td><span class="main-grid-cell-content">{{$order['user_phone']}}</span></td>
                        <td><span class="main-grid-cell-content">{{$order['user_email']}}</span></td>
                        <td>
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
                        <td><span class="main-grid-cell-content">{{$order['payment_method_name']}}</span></td>
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
            <button onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) {@this.deleteSelected()}" type="button" class="btn btn-light"><i class="fa fa-times"></i> Удалить</button>
        </div>
    </div>
</div>
