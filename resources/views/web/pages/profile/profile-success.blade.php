<?php /** @var \Domain\Orders\Models\Order $order */ ?>
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

        <div class="accordion-methods form-group" id="accordionListPayment">
            @foreach($paymentMethods as $paymentMethod)
                <div class="js-payment-method-item">
                    <button
                        class="js-choose-payment-method"
                        type="button"
                        data-id="{{$paymentMethod->id}}"
                        data-order-id="{{$order->id}}"
                        data-toggle="collapse"
                        data-target="#js-method-{{$paymentMethod->id}}"
                        aria-expanded="false"
                        aria-controls="{{$paymentMethod->id}}"
                    >
                        {{$paymentMethod->name}}
                    </button>
                    <div
                        class="collapse"
                        id="js-method-{{$paymentMethod->id}}"
                        data-parent="#accordionListPayment"
                        aria-labelledby="heading{{$paymentMethod->id}}"
                    >
                        <div class="accordion-methods__parent">
                            <div class="form-group__item">
                                <p>{{$paymentMethod->description}}</p>
                            </div>
                            @if($paymentMethod->describable)
                                <div class="form-group__item">
                                    <label>Вы можете указать реквизиты юридического лица:</label>
                                    <textarea class="form-control js-payment-method-description" name="payment_method_description" id="" cols="30" rows="10" placeholder="Реквизиты"></textarea>
                                </div>
                                <div class="form-group__item">
                                    <label>Приложить файл</label>
                                    <div class="block-file">
                                        <div class="bg_img">
                                            <input class="form-control-file js-payment-method-attachment" type="file" name="attachment" multiple />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group__item">
                                    <input type="submit" class="btn-submit" value="Отправить">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
        <p>Вы можете ознакомиться со своими заказами в <a href="{{route("profile")}}">личном кабинете</a>.</p>
    </div>
@endsection
