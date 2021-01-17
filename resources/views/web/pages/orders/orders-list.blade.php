<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $orders */ ?>

<ul>
    <?php /** @var \App\Models\Order $order */ ?>
    @foreach($orders as $order)
        <li>
            <p><a href="#">Заказ # {{$order->id}}</a> @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y H:i:s")}} @endif</p>
            <p>Заказ {{$order->status->name}}</p>
            <p>Сумма {{$order->price_retail}} руб</p>
            <ul>
            <?php /** @var \App\Models\Product\Product $product */ ?>
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
