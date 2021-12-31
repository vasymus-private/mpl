<?php
/**
 * @var array[] $orderHistoryItems @see {@link \Domain\Orders\DTOs\OrderHistoryItem}
 */
?>

<div class="item-edit order-edit">
    <div class="h5 text-center bg-info py-2">
        История изменений
    </div>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Пользователь</th>
            <th scope="col">Операция</th>
            <th scope="col">Описание</th>
        </tr>
        </thead>
        <tbody>
            @foreach($orderHistoryItems as $orderHistoryItem)
                <tr wire:key="order-history-item-{{$orderHistoryItem['orderEventId']}}">
                    <td>
                        <span class="main-grid-cell-content">{{$orderHistoryItem['date']}}</span>
                    </td>
                    <td>
                        <span class="main-grid-cell-content">{{$orderHistoryItem['userName']}}</span>
                    </td>
                    <td>
                        <span class="main-grid-cell-content">{{$orderHistoryItem['operation']}}</span>
                    </td>
                    <td>
                        <span class="main-grid-cell-content">{{$orderHistoryItem['description']}}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
