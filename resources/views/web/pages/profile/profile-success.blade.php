<?php /** @var \App\Models\Order $order */ ?>
<?php /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentMethod[] $paymentMethods */ ?>

@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Моя корзина'"></x-h1>

    <p>Ваш заказ обрабатывается, ему присвоен номер № {{$order->id}}. Сумма заказа {{$order->price_retail}} руб</p>

    <p>На указанный Email будет выслана информация по заказу.</p>
    <p>Менеджер свяжется с Вами для уточнения способа оплаты и получения заказа</p>

    <ul>
        @foreach($paymentMethods as $paymentMethod)
            <li class="js-payment-method-item">
                <p>{{$paymentMethod->description}}</p>
                @if($paymentMethod->describable)
                    <div>
                        <textarea class="js-payment-method-description" name="payment_method_description" id="" cols="30" rows="10" placeholder="Реквизиты"></textarea>
                    </div>
                    <div>
                        <input class="js-payment-method-attachment" type="file" name="attachment" multiple />
                    </div>
                @endif
                <button class="js-choose-payment-method" type="button" data-id="{{$paymentMethod->id}}" data-order-id="{{$order->id}}">{{$paymentMethod->name}}</button>
            </li>
        @endforeach
    </ul>
    <p>Вы можете ознакомиться со своими заказами в <a href="{{route("profile")}}">личном кабинете</a>.</p>
@endsection
