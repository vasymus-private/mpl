@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \Domain\Orders\Models\Order $order */ ?>
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
        <div class="sale-order-detail__content">
            <div class="order-info">
                <h3 class="order-info__title">Информация о пользователе</h3>
                <div class="order-info__item">
                    <span class="order-info__label">Логин:</span>
                    <p class="order-info__text">admin</p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label">E-mail адрес:</span>
                    <p class="order-info__text"><a href="mailto:parket-lux@mail.ru">parket-lux@mail.ru</a></p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label">Тип плательщика:</span>
                    <p class="order-info__text">Физические лица</p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label">Имя:</span>
                    <p class="order-info__text">ssddd</p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label">Приложенный файл:</span>
                    <p class="order-info__text"><a href="#">20cb7e6ee880859507618043c7eaa9a8.doc</a></p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label"></span>
                    <p class="order-info__text"><a href="mailto:parket-lux@mail.ru">parket-lux@mail.ru</a></p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label">Телефон:</span>
                    <p class="order-info__text">123123123</p>
                </div>
                <h3 class="order-info__title">Комментарии к заказу</h3>
                <div class="order-info__item">
                    <p class="order-info__text">Составил Александр для Камила Сиразеева <br>
                        Специалист отдела продаж "VIVUS STROY" <br>
                        Тел: 8(495) 970-34-26 <br>
                        Моб.тел : +7(916) 637-50-51 <br>
                        Моб.тел : +7(915) 492-80-86</p>
                </div>
            </div>
        </div>
        <div class="sale-order-detail__head">
            <span class="sale-order-detail__item">Содержимое заказа</span>
        </div>
        <div class="sale-order-detail__container">
            <div class="sale-order-table cabinet desktop">
                <div class="product-selling">
                    <table class="product-selling__table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><a href="#">Dollken TL-51 (светло-серый) - пластиковый плинтус для ковролина (2,5м)</a></td>
                            <td>348 р</td>
                            <td>6</td>
                            <td><strong>2500 р.</strong></td>
                        </tr>
                        <tr>
                            <td><a href="#">Внутренний угол для плинтуса Dollken TL-51</a></td>
                            <td>348 р</td>
                            <td>6</td>
                            <td><strong>2500 р.</strong></td>
                        </tr>
                        <tr>
                            <td><a href="#">Внутренний угол для плинтуса Dollken TL-51</a></td>
                            <td>90 р</td>
                            <td>6</td>
                            <td><strong>2500 р.</strong></td>
                        </tr>
                        <tr>
                            <td><a href="#">Внутренний угол для плинтуса Dollken TL-51</a></td>
                            <td>90 р</td>
                            <td>6</td>
                            <td><strong>2500 р.</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="sale-order-table cabinet mobile">
                <div class="product-selling">
                    <table class="product-selling__table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4"><a href="#">Dollken TL-51 (светло-серый) - пластиковый плинтус для ковролина (2,5м)</a></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>90 р</td>
                            <td>6</td>
                            <td><strong>2500 р.</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4"><a href="#">Dollken TL-51 (светло-серый) - пластиковый плинтус для ковролина (2,5м)</a></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>90 р</td>
                            <td>6</td>
                            <td><strong>2500 р.</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4"><a href="#">Dollken TL-51 (светло-серый) - пластиковый плинтус для ковролина (2,5м)</a></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>90 р</td>
                            <td>6</td>
                            <td><strong>2500 р.</strong></td>
                        </tr>
                        </tbody>
                    </table>
                    <a href="#" class="btn-repeat">Повторить</a>
                </div>
            </div>
            <!--          				<div class="sale-order-detail__total-payment row-line row-line__right">-->
            <!--          					<div class="column-offset row-line">-->
            <!--          						<div class="column">-->
            <!--          							<span class="total">Итого:</span>-->
            <!--          						</div>-->
            <!--          						<div class="column">-->
            <!--          							<span class="total-price">2 628 р</span>-->
            <!--          						</div>-->
            <!--          					</div>-->
            <!--          				</div>-->
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
