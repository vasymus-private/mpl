<?php
/**
 * @var \App\Http\Livewire\Admin\OrdersList $this
 * @var array[] $items @see {@link \Domain\Products\DTOs\Admin\OrderItemDTO}
 * @var array[] $per_page_options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var array[] $managers @see {@link \Domain\Common\DTOs\OptionDTO}
 */
?>
<div>
    <form wire:submit.prevent="handleSearch">
        <div class="form-group row">
            <label for="item.slug" class="col-sm-5 col-form-label">Дата с:</label>
            <div class="col-sm-7">
                <div class="input-group @error('date_from') is-invalid @enderror">
                    <input wire:model.defer="date_from" type="date" class="form-control @error('date_from') is-invalid @enderror" id="date_from">
                </div>
                @error('date_from') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="item.slug" class="col-sm-5 col-form-label">Дата по:</label>
            <div class="col-sm-7">
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

        <button type="submit" class="btn btn-primary mb-2 btn__save mr-2">Найти</button>
        <button wire:click="clearFilters" type="button" class="btn btn-primary mb-2 btn__save mr-2">Отменить</button>
    </form>

    <div class="table-responsive position-relative">
        <div wire:loading.flex>
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input wire:model="selectAll" class="form-check-input position-static" type="checkbox">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                <th scope="col"><span class="main-grid-head-title">Дата создания</span></th>
                <th scope="col"><span class="main-grid-head-title">ID</span></th>
                <th scope="col"><span class="main-grid-head-title">Статус</span></th>
                <th scope="col"><span class="main-grid-head-title">Комментарии</span></th>
                <th scope="col"><span class="main-grid-head-title">Комментарий покупателя</span></th>
                <th scope="col"><span class="main-grid-head-title">Важность</span></th>
                <th scope="col"><span class="main-grid-head-title">Менеджер</span></th>
                <th scope="col"><span class="main-grid-head-title">Сумма</span></th>
                <th scope="col"><span class="main-grid-head-title">Имя</span></th>
                <th scope="col"><span class="main-grid-head-title">Телефон</span></th>
                <th scope="col"><span class="main-grid-head-title">Email</span></th>
                <th scope="col"><span class="main-grid-head-title" style="width: 300px;">Позиции</span></th>
                <th scope="col"><span class="main-grid-head-title">Платежная система</span></th>
            </tr>
            </thead>
            <tbody>
                @foreach($items as $order)
                    <tr wire:key="product-{{$order['id']}}">
                        <td>
                            <div class="form-check">
                                <input wire:model.defer="items.{{$order['id']}}.is_checked" class="form-check-input position-static" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary" type="button" id="actions-dropdown-{{$order['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></button>
                                <div class="dropdown-menu" aria-labelledby="actions-dropdown-{{$order['id']}}">
                                    <a class="dropdown-item" href="#">Изменить</a>
                                    <a class="dropdown-item" href="#">Копировать</a>
                                    <button type="button" class="dropdown-item btn btn-link" onclick="if (confirm('Вы уверены, что хотите удалить заказ `{{$order['id']}}`?')) {@this.handleDelete({{$order['id']}});}">Удалить</button>
                                </div>
                            </div>
                        </td>
                        <td><span class="main-grid-cell-content">{{$order['date']}}</span></td>
                        <td><span class="main-grid-cell-content">{{$order['id']}}</span></td>
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
                                <?php /** @var array $orderProductItem @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO} */ ?>
                                @foreach($order['products'] as $orderProductItem)
                                    <p>
                                        {{$orderProductItem['name']}} <br>
                                        ({{$orderProductItem['count']}} шт.)
                                        @if(!empty($orderProductItem['unit']))
                                            <br>
                                            Упаковка / единица измерения: {{$orderProductItem['unit']}}
                                        @endif
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

    <div class="row">
        <div class="col-sm-1">
            Всего: {{$total}}
        </div>
        <div class="col-sm-9">
            {{ $paginator->links("admin.pagination.livewire-bootstrap") }}
        </div>
        <div class="col-sm-2">
            @include('admin.livewire.includes.form-group-select', ['field' => 'per_page', 'label' => 'На странице', 'options' => $per_page_options, 'wire' => ['change' => 'handleSearch'], 'nullOption' => false])
        </div>
    </div>

    <div class="row pb-5">
        <div class="col-sm-3" wire:key="delete-btn">
            <button onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) {@this.deleteSelected()}" type="button" class="btn btn-light"><i class="fa fa-times"></i> Удалить</button>
        </div>
    </div>
</div>
