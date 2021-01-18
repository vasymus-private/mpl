@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \App\Models\Order $order */ ?>
    <x-h1 :entity="'Мой заказ №' . $order->id"></x-h1>

    <div class="content__white-block">
        <h2 class="product__title">Заказ № {{$order->id}} @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y H:i:s")}} @endif</h2>

        <x-go-back/>

        <table width="100%">
            <tbody>
                <tr>
                    <th colspan="2" align="left">Основная информация о заказе</th>
                </tr>
                <tr>
                    <td>
                        Текущий статус заказа
                    </td>
                    <td>
                        Заказ {{$order->status_name_for_user}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Сумма заказа
                    </td>
                    <td>
                        {{$order->price_retail_rub_formatted}}
                    </td>
                </tr>
                <tr>
                    <th colspan="2" align="left">Параметры заказа</th>
                </tr>
                <tr>
                    <td>
                        Имя
                    </td>
                    <td>
                        {{ $order->user_name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        E-mail
                    </td>
                    <td>
                        {{ $order->user_email }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Телефон
                    </td>
                    <td>
                        {{ $order->user_phone }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Комментарии покупателя
                    </td>
                    <td>
                        {{ $order->comment_user }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2" align="left">Содержимое заказа</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <td width="80%">Наименование</td>
                                    <td width="10%">Кол-во</td>
                                    <td width="10%">Цена</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->products as $product)
                                    <tr>
                                        <td><a href="{{$product->web_route}}">{{$product->name}}</a></td>
                                        <td>{{$product->order_product_count}}</td>
                                        <td>{{$product->order_product_price_retail_rub_formatted}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td align="right">Итого:</td>
                                    <td colspan="2" align="right">{{$order->price_retail_rub_formatted}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <p><a href="{{route("profile")}}">В список заказов</a></p>
    </div>
@endsection
