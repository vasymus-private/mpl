<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $orders */ ?>
<div class="content__white-block">
    <h2>Мои последние заказы</h2>
    <x-go-back/>
<ul>
    <?php /** @var \Domain\Orders\Models\Order $order */ ?>
    @foreach($orders as $order)
        <li>
            <p><a href="{{route("orders.show", $order->id)}}">Заказ # {{$order->id}}</a> @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y H:i:s")}} @endif</p>
            <p>Заказ {{$order->status_name_for_user}}</p>
            <p>Сумма {{$order->price_retail_rub_formatted}}</p>
            <ul>
            <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
            @foreach($order->products as $product)
                <li>
                    <a href="{{$product->web_route}}">{{$product->name}}</a>
                    Цена: {{$product->order_product_price_retail_rub_formatted}}
                    Количество: {{$product->order_product_count}}
                </li>
            @endforeach
            </ul>
            <p>
                <a href="#">Повторить</a>
            </p>
        </li>
    @endforeach
</ul>
</div>
