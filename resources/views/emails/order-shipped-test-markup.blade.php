<?php /** @var \App\Models\Order $order */ ?>

@extends('emails.layouts.app')

@section('content')
    <h1>Спасибо, что обратились в наш интернет-магазин</h1>
    <p>Ваш заказ номер 1111 от 12.01.2021 обрабатывается.</p>
    <p>Менеджер свяжется с Вами для уточнения способа оплаты и получения заказа.</p>
    <p>Стоимость заказа: <b>1 100 р</b>.</p>
    <p>Состав заказа:</p>
    <div class="table">
        <table>
            <tbody>
                <tr>
                    <td><a href="#"></a></td>
                    <td align="center">{{$product->pivot_count}} шт. x {{$product->pivot_price_retail_rub_formatted}}</td>
                    <td align="right">{{ $product->pivot_price_retail_rub_sum_formatted }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <table class="action" align="center">
        <tbody>
        <tr>
            <td align="center">
                <a href="#" class="button button-primary" target="_blank">Перейти в личный кабинет</a>
            </td>
        </tr>
        </tbody>
    </table>
    <p>В личном кабинете Вы можете увидеть свои заказы.</p>
    <p>Для входа в личный кабинет запомните присвоенный Вам пароль <b>IHFDEC</b>, логином является ваш e-mail.</p>
    <p>Пожалуйста, при обращении к администрации сайта market-parket.ru ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - 9491. Связаться с менеджером можно по телефону: <a href="">+7(495) 760-05-18</a>.</p>
    <p>Спасибо за покупку!</p>
    <p>
        С уважением,<br/>
        администрация <a href="#">Интернет-магазина</a> <br/>
        E-mail: <a href="#">mail@market-parket.ru</a>
    </p>
@endsection
