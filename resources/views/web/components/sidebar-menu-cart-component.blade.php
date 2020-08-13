@if(count($cartProducts))
<div class="sidebar-basket-block">
    <div class="sidebar-basket-block__title"><a href="{{route("cart.show")}}">Ваша корзина</a></div>
    <div class="sidebar-basket-block__body js-sidebar-menu-cart-list">
        @foreach($cartProducts as $cartProduct)
            <?php /** @var \App\Models\Product\Product $cartProduct */ ?>
            <div class="sidebar-basket-block__cartitem" data-id="{{$cartProduct->id}}">
                <h4><a href="{{$cartProduct->web_route}}">{!! $cartProduct->name !!}</a></h4>
                <div class="sidebar-basket-block__price">
                    <span class="sidebar-basket-block__qty">{{ $cartProduct->pivot->count ?? 1 }} шт</span>
                    {{$cartProduct->price_name}}: <strong class="sidebar-basket-block__text-orange">{{$cartProduct->price_retail_rub_formatted}}</strong>
                    <strong> / {{$cartProduct->unit}}</strong>
                </div>
            </div>
        @endforeach
        <div class="sidebar-basket-block__cartresume">
            <h5>Сумма: {{$totalSumFormatted}}</h5>
            <div class="sidebar-basket-block__cart_block_button">
                <a href="{{route("cart.show")}}">Перейти в корзину</a>
            </div>
        </div>
    </div>
</div>
@endif
