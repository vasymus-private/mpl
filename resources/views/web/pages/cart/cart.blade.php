@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Моя корзина'"></x-h1>

    <a href="#" class="js-back">Вернуться</a>

    <form action="#" id="form-order">
        <div>
            <label for="name">Имя:</label>
        </div>
        <div>
            <input type="text" id="name" name="name" />
        </div>

        <div>
            <label for="email">E-mail:</label>
        </div>
        <div>
            <input type="text" id="email" name="email" />
        </div>

        <div>
            <label for="phone">Телефон:</label>
        </div>
        <div>
            +7 <input type="text" id="phone" name="phone" />
        </div>
    </form>

    <div>
        <p>Проверьте ваш заказ:</p>
    </div>

    <style>
        .deleted-row td {
            text-decoration: line-through;
        }
    </style>

    @if(count($cartProducts))
        <table>
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Ед.</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartProducts as $cartProduct)
                <?php /** @var \App\Models\Product\Product $cartProduct */ ?>
                <tr class="js-cart-row {{ ($cartProduct->pivot->deleted_at ?? null) !== null ? "deleted-row" : "" }}" data-id="{{$cartProduct->id}}">
                    <td>
                        <img src="{{$cartProduct->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" alt="" style="max-width: 40px;" />
                        {!! $cartProduct->name !!}
                    </td>
                    <td>
                        {{$cartProduct->price_retail_rub_formatted}}
                    </td>
                    <td>
                        {{$cartProduct->unit}}
                    </td>
                    <td>
                        <div class="js-cart-column-count-part-normal" @if(($cartProduct->pivot->deleted_at ?? null) !== null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                            <button type="button" class="js-cart-decrement" data-id="{{$cartProduct->id}}">-</button>
                            <input type="text" value="{{$cartProduct->pivot->count ?? 1}}" class="js-input-hide-on-focus js-add-to-cart-input-count js-add-to-cart-input-count-{{$cartProduct->id}}" data-id="{{$cartProduct->id}}" />
                            <button type="button" class="js-cart-increment" data-id="{{$cartProduct->id}}">+</button>
                        </div>
                        <div class="js-cart-column-count-part-deleted" @if(($cartProduct->pivot->deleted_at ?? null) === null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                            <button type="button" class="js-cart-restore" data-id="{{$cartProduct->id}}">Вернуть</button>
                            <button type="button" class="js-cart-destroy" data-id="{{$cartProduct->id}}">Удалить</button>
                        </div>
                    </td>
                    <td>
                        <span class="js-cart-item-sum-formatted" data-id="{{$cartProduct->id}}">{{ ($cartProduct->pivot->count ?? 1) * $cartProduct->price_retail_rub }} р</span>
                    </td>
                    <td>
                        <a href="#" class="js-cart-delete" data-id="{{$cartProduct->id}}" @if(($cartProduct->pivot->deleted_at ?? null) !== null) style="display: none;" @endif>X</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Итого: <span class="js-cart-total-sum-formatted">{{$cartProducts->reduce(function($acc, \App\Models\Product\Product $item) { return $acc += ($item->price_retail_rub * ($item->pivot->count ?? 1)); }, 0)}} р</span></p>
    @else
        <p>У вас пустая корзина.</p>
    @endif

    <div>
        <p><b><label for="comment">Вы можете оставить комментарий:</label></b></p>
        <div>
            <textarea name="comment" id="comment" style="width: 100%; min-height: 50px;" placeholder="Адрес доставки или самовывоз. Удобный способ оплаты."></textarea>
        </div>
    </div>
    <div>
        <p><b><label for="file">Вы можете прикрепить файл:</label></b></p>
        <div>
            <input type="file" id="file" name="file" />
        </div>
    </div>
    <div>
        <button type="submit" form="form-order">Отправить заказ</button>
    </div>
    <p>Нажимая на кнопку "Отправить заказ", я даю <a href="#" data-fancybox="consent-processing-personal-data" data-src="#consent-processing-personal-data">согласие на обработку своих персональных данных</a></p>
@endsection
