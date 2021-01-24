<?php /** @var \App\Models\Order $order */ ?>
<?php /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentMethod[] $paymentMethods */ ?>

@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Моя корзина'"></x-h1>
    <div class="content__white-block">
        <div class="order-text-block">
            <h5 class="order-text-block__title">Ваш заказ обрабатывается, ему присвоен номер № {{$order->id}}. Сумма заказа {{$order->price_retail_rub_formatted}}</h5>
            <p class="order-text-block__text">На указанный Email будет выслана информация по заказу.</p>
            <p class="order-text-block__text">Менеджер свяжется с Вами для уточнения способа оплаты и получения заказа</p>
        </div>

        <div class="accordion" id="accordionListPayment">
            @foreach($paymentMethods as $paymentMethod)
                <div class="js-payment-method-item">
                    <button
                        class="js-choose-payment-method"
                        type="button"
                        data-id="{{$paymentMethod->id}}"
                        data-order-id="{{$order->id}}"
                        data-toggle="collapse"
                        data-target="{{$paymentMethod->id}}"
                        aria-expanded="true"
                        aria-controls="{{$paymentMethod->id}}"
                    >
                        {{$paymentMethod->name}}
                    </button>
                    <div
                        class="collapse"
                        id="{{$paymentMethod->id}}"
                        data-parent="#accordionListPayment"
                        aria-labelledby="heading{{$paymentMethod->id}}"
                    >
                        <p>{{$paymentMethod->description}}</p>
                        @if($paymentMethod->describable)
                            <div>
                                <textarea class="js-payment-method-description" name="payment_method_description" id="" cols="30" rows="10" placeholder="Реквизиты"></textarea>
                            </div>
                            <div>
                                <input class="js-payment-method-attachment" type="file" name="attachment" multiple />
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </ul>
        <p>Вы можете ознакомиться со своими заказами в <a href="{{route("profile")}}">личном кабинете</a>.</p>
    </div>
@endsection
