@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Моя корзина'"></x-h1>
    <div class="block-back-page row-line row-line__right">
        <div class="column-back">
            <a href="#" class="js-back">
                <img src="../images/backarow.svg" width="97" alt="">
            </a>
        </div>
    </div>
    <div class="content__white-block cart">
        <form action="{{route("cart.checkout")}}" method="POST" class="form-group" enctype="multipart/form-data" id="form-order">
            @csrf
            @if(\Illuminate\Support\Facades\Auth::user()->is_anonymous2)
                <div class="form-group__item">
                    <label for="name">Имя:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{old("name")}}"/>
                    @if($errors->has("name"))
                        <div>
                            <span style="color:red">{{$errors->first("name")}}</span>
                        </div>
                    @endif
                </div>

                <div class="form-group__item">
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{old("email")}}"/>
                    @if($errors->has("email"))
                        <div>
                            <span style="color:red">{{$errors->first("email")}}</span>
                        </div>
                    @endif
                </div>
                <div class="form-group__item">
                    <label for="phone">Телефон:</label>
                    <div class="row-line row-line__center">
                        <span class="phone-t">+7</span>  
                        <input class="form-control small" type="text" id="phone" name="phone" value="{{old("phone")}}"/>
                    </div>
                    @if($errors->has("phone"))
                        <div>
                            <span style="color:red">{{$errors->first("phone")}}</span>
                        </div>
                    @endif
                </div>    
            @endif
        </form>

        <div class="cart-block">
            <h4 class="cart__title">Проверьте ваш заказ:</h4>
            @if(count($cartProducts))
                <table class="cart__table">
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
                        <tr class="js-cart-row {{ ($cartProduct->cart_product->deleted_at ?? null) !== null ? "deleted-row" : "" }}" data-id="{{$cartProduct->id}}">
                            <td>
                                <div class="row-line">
                                    <img src="{{$cartProduct->main_image_url}}" alt="" class="cart__image" />
                                    <span class="cart__name-product">{!! $cartProduct->name !!}</span>
                                </div>      
                            </td>
                            <td>
                                {{$cartProduct->price_retail_rub_formatted}}
                            </td>
                            <td>
                                {{$cartProduct->unit}}
                            </td>
                            <td class="count-td">
                                <div class="js-cart-column-count-part-normal" @if(($cartProduct->cart_product->deleted_at ?? null) !== null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                                    <button type="button" class="js-cart-decrement" data-id="{{$cartProduct->id}}">-</button>
                                    <input type="text" value="{{$cartProduct->cart_product->count ?? 1}}" class="js-input-hide-on-focus js-add-to-cart-input-count js-add-to-cart-input-count-{{$cartProduct->id}}" data-id="{{$cartProduct->id}}" />
                                    <button type="button" class="js-cart-increment" data-id="{{$cartProduct->id}}">+</button>
                                </div>
                                <div class="js-cart-column-count-part-deleted" @if(($cartProduct->cart_product->deleted_at ?? null) === null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                                    <button type="button" class="js-cart-restore" data-id="{{$cartProduct->id}}">Вернуть</button>
                                    <button type="button" class="js-cart-destroy" data-id="{{$cartProduct->id}}">Удалить</button>
                                </div>
                            </td>
                            <td>
                                <span class="js-cart-item-sum-formatted" data-id="{{$cartProduct->id}}">{{ ($cartProduct->cart_product->count ?? 1) * $cartProduct->price_retail_rub }} р</span>
                            </td>
                            <td>
                                <a href="#" class="js-cart-delete" data-id="{{$cartProduct->id}}" @if(($cartProduct->cart_product->deleted_at ?? null) !== null) style="display: none;" @endif>&nbsp;</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="cart__items">
                    <p>Итого: <span class="js-cart-total-sum-formatted">{{$cartProducts->reduce(function($acc, \App\Models\Product\Product $item) { return $acc += ($item->price_retail_rub * ($item->cart_product->count ?? 1)); }, 0)}} р</span></p>
                </div>                
            @else
                <p>У вас пустая корзина.</p>
            @endif
        </div>

        <div class="cart__text-ar">
            <p><b><label for="comment">Вы можете оставить комментарий:</label></b></p>
            <div>
                <textarea name="comment" id="comment" form="form-order" style="width: 100%; min-height: 50px;" placeholder="Адрес доставки или самовывоз. Удобный способ оплаты.">{{old("comment")}}</textarea>
            </div>
            @if($errors->has("comment"))
                <div>
                    <span style="color:red">{{$errors->first("comment")}}</span>
                </div>
            @endif
        </div>
        <div>
            <p><b><label for="attachment">Вы можете прикрепить файл:</label></b></p>
            <div>
                <input form="form-order" type="file" id="attachment" name="attachment[]" multiple />
            </div>
            @if($errors->has("attachment"))
                <div>
                    <span style="color:red">{{$errors->first("attachment")}}</span>
                </div>
            @endif
        </div>
        <div>
            <button type="submit" form="form-order">Отправить заказ</button>
        </div>
        @if($errors->has("cart"))
            <div>
                <span style="color:red">{{$errors->first("cart")}}</span>
            </div>
        @endif
        @if(session()->has('cart-error'))
            <div>
                <span style="color:red">{{session()->get('cart-error')}}</span>
            </div>
        @endif
        <p>Нажимая на кнопку "Отправить заказ", я даю <a href="#" data-fancybox="consent-processing-personal-data" data-src="#consent-processing-personal-data">согласие на обработку своих персональных данных</a></p>
    </div>
@endsection
