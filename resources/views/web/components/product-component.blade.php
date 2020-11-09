<?php /** @var \App\Models\Product\Product $product */ ?>
<div class="content__white-block">
    <h2 class="product__title">{!! $product->name !!}</h2>

    <div class="put-product row-line row-line__between">
        <div class="put-off-block">
            <a href="#" data-id="{{$product->id}}" class="js-put-aside put-off-block__link {{in_array($product->id, $asideIds) ? "put-off-block__link--active" : ""}}">
                <i class="fa fa-bookmark" aria-hidden="true"></i>
                Отложить
            </a>
        </div>

        @include("web.components.includes.product.instructions", ["instructions" => $instructions()])
    </div>

    @if($isWithVariations())
        <div class="row-line product-line">
            <div class="column">
                <div class="product__photo">
                    <a href="{{$mainImage()}}" data-fancybox="images"><img src="{{$mainImage()}}" alt="{{$product->name}}" title="{{$product->name}}" /></a>
                </div>
            </div>
            <div class="column">
                @include("web.components.includes.product.brand", ["brand" => $product->brand])

                @include("web.components.includes.product.images-thumbs", ["images" => $images()])
            </div>
        </div>
    @endif

    @if(! $isWithVariations())
        <div class="row-line product-line">
            <div class="column">
                <div class="product__photo">
                    <a href="{{$mainImage()}}" data-fancybox="images"><img src="{{$mainImage()}}" alt="{{$product->name}}" title="{{$product->name}}" /></a>
                </div>

                @include("web.components.includes.product.images-thumbs", ["images" => $images()])
            </div>
            <div class="column">
                <div class="product-price">
                    <div class="product-price__top row-line row-line__center row-line__jc-center">
                        <div class="column-price">
                            <span class="product-price__subtitle">{{ $product->price_name }}</span>
                            <span class="product-price__count-block">{{ $product->price_retail_rub_formatted }}</span>
                        </div>
                        <div class="column-price">
                            <span class="product-price__subtitle">Упаковка</span>
                            <span class="product-price__count-block-gray">/ {{$product->unit}}</span>
                        </div>
                    </div>
                    <div class="product-price__body row-line row-line__between">
                        <div class="column-price-part">
                            <span class="product-price__subtitle">Количество</span>
                            <input type="number" min="1" class="js-add-to-cart-input-count-{{$product->id}} js-input-hide-on-focus" value="1" />
                        </div>
                        @if($product->is_available)
                        <div class="column-price-part">
                            <div class="available-blocker">
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                В наличии
                            </div>
                            <button
                                type="button"
                                class="js-add-to-cart product-price__add {{ $product->is_available_in_stock ? "available-in-stock" : "" }} {{$product->is_available_not_in_stock ? "available-not-in-stock" : ""}}"
                                data-id="{{$product->id}}"
                                data-is-in-cart="{{(int)$product->is_in_cart}}"
                            >{{$product->is_in_cart ? "Добавить" : "В корзину"}}</button>
                        </div>
                        @else
                            <div class="available-blocker">
                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                Нет в наличии
                            </div>
                        @endif
                    </div>
                    <div class="product-price__description">
                        {{$product->coefficient_description}} - {{$product->coefficient_price_rub_formatted}}
                    </div>
                </div>

                @include("web.components.includes.product.brand", ["brand" => $product->brand])
            </div>
        </div>
    @endif



    {{-- Если товар с вариантами --}}
    @if($isWithVariations()))
        <div class="product-variants">
            <table width="100%" cellspacing="0" cellpadding="7" border="0">
                <thead>
                    <tr>
                        <th colspan="2">Варианты:</th>
                        {{--<th>{{$product->unit}}</th>--}}
                        <th>Цена</th>
                        <th>Уп-ка</th>
                        <th>Кол-во</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                {{--<tr>
                    <th colspan="2">Варианты:</th>
                    <th>1000г</th>
                    <th>Цена</th>
                    <th>Уп-ка</th>
                    <th>Кол-во</th>
                    <th>&nbsp;</th>
                </tr>--}}
                @foreach($product->variations as $variation)
                    <?php /** @var \App\Models\Product\Product $variation */ ?>
                <tr>
                    <td>
                        <div class="product-variants__photo">
                            <a data-fancybox="variation-image-loop-{{$loop->index + 1}}" href="{{$variation->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}"><img src="{{$variation->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" alt="{{$variation->name}}" title="{{$variation->name}}"></a>
                            <span class="product-variants__counter">{{$loop->index + 1}}</span>
                            <a data-fancybox="variation-image-loop-{{$loop->index + 1}}" href="{{$variation->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" class="product-variants__zoom"></a>
                        </div>
                    </td>
                    <td>
                        <h3 class="product-variants__title" data-offer="1785">
                            <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-html="true" data-content="{{$variation->preview}}" title="">{{$variation->name}}</a>
                        </h3>
                    </td>
                    {{--<td>
                        <strong class="product-variants__price-blue">{{$variation->price_retail_rub_formatted}}</strong>
                    </td>--}}
                    <td width="10%">
                        <strong class="product-variants__price-orange">{{$variation->price_retail_rub_formatted}}</strong>
                    </td>
                    <td>
                        <strong class="product-variants__price-gray">{{$variation->unit}}</strong>
                    </td>
                    <td width="10%">
                        <input type="text" value="1" class="product-variants__input_small">
                    </td>
                    <td width="10%" align="right">
                        <a class="button-buy color-orange addToCart" data-id="1785" data-order="1" href="#" data-qty="#qty_1785">На заказ</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div class="manager-area-price">
                            <p><span>Закупочная:</span> <span style="color: #03c; font-weight: bold;">0</span>,Маржа: <span style="color: #03c;">1 270 р</span>,
                                Наценка: inf%,
                                Заработок: 100.00%</p>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mob-products">
                <h3>Варианты</h3>
                <div class="over-line">
                    <div class="column">
                        <div class="product-variants__photo">
                            <a href="#"><img src="images/product-variants.jpeg" alt="Клей для паркета  ACM VK-L12" title="Клей ACM VK-L12"></a>
                            <span class="product-variants__counter">1</span>
                            <a href="#" class="product-variants__zoom"></a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="block-text-product">
                            <h4 class="product-variants__title">
                                <a data-toggle="popover" data-placement="top" data-html="true" data-content="Пластиковое ведро. Прочно-эластичный, двухкомпонентный, полиуретановый клей. Не содержит воды и растворителей. " class="pointer link-text js-auto-hide-popover" data-original-title="" title="">Клей ACM VK-L12 (10кг)</a>
                            </h4>
                            <div class="line-product right">
                                <span class="text-orange">3 387 р <span class="text-gray">/ 10кг</span></span>
                            </div>
                            <div class="product-amount row-line">
                                <div class="column">
                                    <input type="hidden" value="1" name="qty">
                                    <input type="text" value="1" class="product-variants__input_small">
                                </div>
                                <div class="column">
                                    <input type="button" value="На заказ" class="add-basket color-orange addToCart" data-id="1785" data-order="1" data-qty="#mqty_1785">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="over-line">
                    <div class="column">
                        <div class="product-variants__photo">
                            <a href="#"><img src="images/product-variants.jpeg" alt="Клей для паркета  ACM VK-L12" title="Клей ACM VK-L12"></a>
                            <span class="product-variants__counter">1</span>
                            <a href="#" class="product-variants__zoom"></a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="block-text-product">
                            <h4 class="product-variants__title">
                                <a data-toggle="popover" data-placement="top" data-html="true" data-content="Пластиковое ведро. Прочно-эластичный, двухкомпонентный, полиуретановый клей. Не содержит воды и растворителей. " class="pointer link-text js-auto-hide-popover" data-original-title="" title="">Клей ACM VK-L12 (10кг)</a>
                            </h4>
                            <div class="line-product right">
                                <span class="text-orange">3 387 р <span class="text-gray">/ 10кг</span></span>
                            </div>
                            <div class="product-amount row-line">
                                <div class="column">
                                    <input type="hidden" value="1" name="qty">
                                    <input type="text" value="1" class="product-variants__input_small">
                                </div>
                                <div class="column">
                                    <input type="button" value="В корзину" class="add-basket addToCart" data-id="1785" data-order="1" data-qty="#mqty_1785">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="over-line">
                    <div class="column">
                        <div class="product-variants__photo">
                            <a href="#"><img src="images/product-variants.jpeg" alt="Клей для паркета  ACM VK-L12" title="Клей ACM VK-L12"></a>
                            <span class="product-variants__counter">1</span>
                            <a href="#" class="product-variants__zoom"></a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="block-text-product">
                            <h4 class="product-variants__title">
                                <a data-toggle="popover" data-placement="top" data-html="true" data-content="Пластиковое ведро. Прочно-эластичный, двухкомпонентный, полиуретановый клей. Не содержит воды и растворителей. " class="pointer link-text js-auto-hide-popover" data-original-title="" title="">Клей ACM VK-L12 (10кг)</a>
                            </h4>
                            <div class="line-product right">
                                <span class="text-orange">3 387 р <span class="text-gray">/ 10кг</span></span>
                            </div>
                            <div class="product-amount">
                                <strong>Нет в наличии</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>



{{-- Если товар без вариантов --}}
@if(! $isWithVariations())
<div
    class="js-product-item-popover"
    data-content="<p>Закупочная: {{$product->price_purchase_rub_formatted}}</p><p>Маржа: {{$product->margin_rub_formatted}}</p><p>Наценка: {{$product->price_markup}} %</p><p>Заработок: {{$product->price_income}} %</p><p>{{$product->admin_comment}}</p>"
    data-placement="bottom"
>
    <p>{{$product->price_name}}:</p>
    <p style="color:#ff5100;">{{$product->price_retail_rub_formatted}}</p>
    <p>Упаковка</p>
    <p>{{$product->unit}}</p>
    @if($product->is_available)
    <p><input type="number" min="1" class="js-add-to-cart-input-count-{{$product->id}} js-input-hide-on-focus" value="1" /></p>
    <p><button
            type="button"
            class="js-add-to-cart {{ $product->availability_status_id === \App\Models\AvailabilityStatus::ID_AVAILABLE_IN_STOCK ? "available-in-stock" : "" }} {{$product->availability_status_id === \App\Models\AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK ? "available-not-in-stock" : ""}}"
            data-id="{{$product->id}}"
            data-is-in-cart="{{(int)$product->is_in_cart}}"
        >{{$product->is_in_cart ? "Добавить" : "В корзину"}}</button></p>
    @else
    <p>Нет в наличии</p>
    @endif
    @if($product->coefficient_description_show)
        <p>{{$product->coefficient_description}} - {{$product->coefficient_price_rub_formatted}}</p>
    @endif
</div>
@endif


{{-- Если товар с вариантами --}}
@if($isWithVariations())
<div>
    <style>.product-variations-image-view svg {width: 20px; height: 20px; color: #000;}</style>
    <table width="100%">
        <thead>
            <tr>
                <th>Варианты:</th>
                <th>Цена</th>
                <th>Уп-ка</th>
                <th>Кол-во</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product->variations as $variation)
                <?php /** @var \App\Models\Product\Product $variation */ ?>
                <tr>
                    <td>
                        <p>{{$loop->index + 1}}</p>
                        <p>
                            <a class="product-variations-image-view" data-fancybox="variation-image-loop-{{$loop->index + 1}}" href="{{$variation->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z"></path>
                                </svg>
                            </a>
                            <a data-fancybox="variation-image-id-{{$variation->id}}" href="{{$variation->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}">
                                <img style="max-width: 50px;" src="{{$variation->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" alt="" />
                            </a>
                        </p>
                        <p>{{$variation->name}}</p>
                    </td>
                    <td>
                        {{$variation->price_retail_rub_formatted}}
                    </td>
                    <td>
                        {{$variation->unit}}
                    </td>
                    <td>
                        @if($variation->is_available)
                            <input type="number" min="1" class="js-add-to-cart-input-count-{{$variation->id}} js-input-hide-on-focus" value="1" />
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>
                        @if($variation->is_available)
                            <button
                                class="{{ $variation->availability_status_id === \App\Models\AvailabilityStatus::ID_AVAILABLE_IN_STOCK ? "available-in-stock" : "" }} {{$variation->availability_status_id === \App\Models\AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK ? "available-not-in-stock" : ""}} js-add-to-cart"
                                type="button"
                                data-id="{{$variation->id}}"
                                data-is-in-cart="{{(int)$variation->is_in_cart}}"
                            >{{ $variation->is_in_cart ? "Добавить" : "В корзину" }}</button>
                        @else
                            Нет в наличии
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>Закупочная: {{$variation->price_purchase_rub_formatted}} | Маржа: {{$variation->margin_rub_formatted}} | Наценка: {{$variation->price_markup}} % | Заработок: {{$variation->price_income}} %</p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif


{{-- Якоря для "Описание" и "Характеристики" --}}
<div>
    <p><a href="#description">Описание</a></p>
    @if($product->characteristicsNotEmpty())<p><a href="#characteristics">Характеристики</a></p>@endif
</div>

{{-- Блок "Описание" --}}
<div id="description">
    {!! $product->description !!}
</div>
<div>
    <p>Сравните {{$product->name}} с товарами других брендов, {{$product->name}} по низкой цене, купите или закажите с доставкой и гарантией качества {{$product->name}} в интернет-магазине.</p>
</div>

{{-- Связанные с продуктом иснтрументы --}}
<div>
    <p>{{$product->accessory_name}}</p>
    @foreach($product->accessory as $accessoryItem)
    <?php /** @var \App\Models\Product\Product $accessoryItem */ ?>
    <div>
        <p><a href="{{$accessoryItem->getRoute()}}"><img style="max-width: 40px;" src="{{$accessoryItem->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" alt="" /></a></p>
        <p><a href="{{$accessoryItem->getRoute()}}">{{$accessoryItem->name}}</a></p>
        <p>{{$accessoryItem->price_retail_rub_formatted}}</p>
    </div>
    @endforeach
</div>

{{-- Блок "Характеристики" --}}
@if($product->characteristicsNotEmpty())
<div id="characteristics">
    <p><b>Характирестики: {{$product->name}}</b></p>
    <table width="100%">
        <tbody>
    @foreach($product->characteristics() as $groupName => $labelValues)
            <tr>
                <td colspan="2"><b>{{$groupName}}</b></td>
            </tr>
            @foreach($labelValues as $label => $value)
                @if($value)
                    <tr>
                        <td>{{$label}}</td>
                        <td>
                            @if(in_array($label, \App\Models\Product\Product::CH_RATE))
                                @for($i = 0; $i < \App\Models\Product\Product::MAX_CHARACTERISTIC_RATE; $i++)
                                    @if($value > $i)
                                        <img src="{{asset("images//general/circle-active.gif")}}" alt="">
                                    @else
                                        <img src="{{asset("images//general/circle.gif")}}" alt="">
                                    @endif
                                @endfor
                            @else
                                {{$value}}
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
    @endforeach
        </tbody>
    </table>
</div>
@endif


{{-- Призыв купить (для сео) TODO подумать правильный тег --}}
<p>
    {{$product->name}} в магазине, Вы можете купить {{$product->name}}, узнайте подробные технические характеристики и цену на {{$product->name}}, фотографии и отзывы посетителей помогут Вам определиться с покупкой, {{$product->name}} - закажите с доставкой на дом.
</p>

{{-- Похожие товары --}}
@if($product->similar->isNotEmpty())
<p><b>{{$product->similar_name}}</b></p>
<ul>
@foreach($product->similar as $item)
    <?php /** @var \App\Models\Product\Product $item */ ?>
    <li>
        <p>{{$item->name}}</p>
        <p><img style="max-width: 150px" src="{{$item->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" alt="" /></p>
        <p>{{$item->price_retail_rub_formatted}}</p>
        <p><a href="{{$item->getRoute()}}">Купить</a></p>
    </li>
@endforeach
</ul>
@endif

{{-- Сопряженные товары --}}
@if($product->related->isNotEmpty())
    <p><b>{{$product->related_name}}</b></p>
    <ul>
        @foreach($product->related as $item)
            <?php /** @var \App\Models\Product\Product $item */ ?>
            <li>
                <p>{{$item->name}}</p>
                <p><img style="max-width: 150px" src="{{$item->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" alt="" /></p>
                <p>{{$item->price_retail_rub_formatted}}</p>
                <p><a href="{{$item->getRoute()}}">Купить</a></p>
            </li>
        @endforeach
    </ul>
@endif

{{-- Работы --}}
@if($product->works->isNotEmpty())
    <p><b>{{$product->work_name}}</b></p>
    <ul>
        @foreach($product->works as $item)
            <?php /** @var \App\Models\Product\Product $item */ ?>
            <li>
                <p>{{$item->name}}</p>
                <p><img style="max-width: 150px" src="{{$item->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}" alt="" /></p>
                <p>{{$item->price_retail_rub_formatted}}</p>
                <p><a href="{{$item->getRoute()}}">Купить</a></p>
            </li>
        @endforeach
    </ul>
@endif
