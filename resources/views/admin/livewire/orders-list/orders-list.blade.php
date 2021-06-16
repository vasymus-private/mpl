<?php
/**
 * @var \App\Http\Livewire\Admin\OrdersList $this
 * @var array[] $items @see {@link \Domain\Products\DTOs\Admin\OrderItemDTO}
 * @var array[] $per_page_options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 */
?>
<div>
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
            <th scope="col"><span class="main-grid-head-title">Менеджер</span></th>
            <th scope="col"><span class="main-grid-head-title">Сумма</span></th>
            <th scope="col"><span class="main-grid-head-title">Имя</span></th>
            <th scope="col"><span class="main-grid-head-title">Телефон</span></th>
            <th scope="col"><span class="main-grid-head-title">Email</span></th>
            <th scope="col"><span class="main-grid-head-title">Позиции</span></th>
            <th scope="col"><span class="main-grid-head-title">Платежная система</span></th>
        </tr>
        </thead>
        <tbody>
            @foreach($items as $order)
                <tr wire:key="product-{{$order['id']}}">
                    <td>
                        <div class="form-check">
                            <input wire:model.defer="items.{{$order['id']}}.is_checked" @if($editMode) disabled @endif class="form-check-input position-static" type="checkbox">
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
                    <td><span class="main-grid-cell-content">{{$order['order_status_name']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$order['comment_admin']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$order['comment_user']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$order['admin_name']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$order['order_price_retail_rub_formatted']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$order['user_name']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$order['user_phone']}}</span></td>
                    <td><span class="main-grid-cell-content">{{$order['user_email']}}</span></td>
                    <td>
                        <?php /** @var array $orderProductItem @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO} */ ?>
                        @foreach($order['products'] as $orderProductItem)
                            <p>[{{$orderProductItem['id']}}] {{$orderProductItem['name']}}</p>
                            <p>({{$orderProductItem['count']}} шт.)</p>
                            @if(!empty($orderProductItem['unit']))
                                <p>Упаковка / единица измерения: {{$orderProductItem['unit']}}</p>
                            @endif
                        @endforeach
                    </td>
                    <td><span class="main-grid-cell-content">{{$order['payment_method_name']}}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
