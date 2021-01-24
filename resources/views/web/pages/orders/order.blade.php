@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \App\Models\Order $order */ ?>
    <x-h1 :entity="'Мой заказ №' . $order->id"></x-h1>

    <div class="content__white-block sale-order-detail">
        <h2 class="sale-order-detail__title">Заказ № {{$order->id}} @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y H:i:s")}} @endif</h2>
        <div class="row-line">
            <a href="{{route("profile")}}" class="sale-order-detail__link-back">← Вернуться в список заказов</a>
        </div>
        <div class="sale-order-detail">
            <div class="sale-order-detail__head">
                <span class="sale-order-detail__item">Заказ №2131 от 11.12.2015, 4 товара на сумму 2 628 р</span>
            </div>
            <div class="sale-order-detail__container">
                <h3 class="sale-order-detail__subtitle">Информация о заказе</h3>
                <div class="row-line item">
                    <div class="column">
                        <h3 class="sale-order-detail__name-title">Ф.И.О.:</h3>
                        <p class="sale-order-detail__name-detail">{{ $order->user_name }}</p>
                    </div>
                    <div class="column">
                        <h3 class="sale-order-detail__name-title sale-order-detail__name-title--color-gree">Текущий статус, от 11.12.2015:</h3>
                        <p class="sale-order-detail__name-detail">Заказ {{$order->status_name_for_user}}</p>
                    </div>
                    <div class="column">
                        <h3 class="sale-order-detail__name-title sale-order-detail__name-title--color-gree">Сумма:</h3>
                        <p class="sale-order-detail__name-detail">{{$order->price_retail_rub_formatted}}</p>
                    </div>
                    <div class="column">
                        <a href="#" class="sale-order-detail__btn">Повторить заказ</a>
                        <a href="#" class="sale-order-detail__cancel">Отменить</a>
                    </div>
                    <div class="column-full-width">
                        <a href="javascript:void(0);" class="sale-order-detail__read-more">подробнее</a>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
@endsection
