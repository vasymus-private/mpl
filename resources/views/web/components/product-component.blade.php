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

    {{-- Product line --}}
    @if($isWithVariations())
        <div class="row-line product-line">
            <div class="column">
                @include("web.components.includes.product.main-image", ["mainImage" => $mainImage(), "productName" => $product->name])
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
                @include("web.components.includes.product.main-image", ["mainImage" => $mainImage(), "productName" => $product->name])

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
                            <input type="number" min="1" class="js-add-to-cart-input-count-{{$product->id}} js-input-hide-on-focus product-price__count" value="1" />
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
    {{-- END Product line --}}


    {{-- Если товар с вариантами --}}
    @if($isWithVariations())
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
                @foreach($product->variations as $variation)
                    <?php /** @var \App\Models\Product\Product $variation */ ?>
                <tr>
                    <td>
                        <div class="product-variants__photo">
                            <a
                                href="{{$variation->main_image_url}}"
                                data-fancybox="variation-image-link-loop-{{$loop->index + 1}}"
                            >
                                <img
                                    src="{{$variation->main_image_url}}"
                                    alt="{{$variation->name}}"
                                    title="{{$variation->name}}">
                            </a>
                            <span class="product-variants__counter">{{$loop->index + 1}}</span>
                            <a
                                class="product-variants__zoom"
                                href="{{$variation->main_image_url}}"
                                data-fancybox="variation-image-loop-{{$loop->index + 1}}"
                            ></a>
                        </div>
                    </td>
                    <td>
                        <h3 class="product-variants__title">
                            <a
                                href="#"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{!! $variation->preview !!}"
                                data-html="true"
                            >{{$variation->name}}</a>
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
                        @if($variation->is_available)
                        <input
                            type="number"
                            value="1"
                            min="1"
                            class="
                            product-variants__input_small
                            js-add-to-cart-input-count-{{$variation->id}}
                            js-input-hide-on-focus
                            "
                        />
                        @endif
                    </td>
                    <td width="10%" align="right">
                        @if($variation->is_available)
                            <button
                                class="
                                {{ $variation->is_available_in_stock ? "red-color" : "" }}
                                {{$variation->is_available_not_in_stock ? "color-orange" : ""}}
                                js-add-to-cart
                                button-buy
                                addToCart
                                "
                                type="button"
                                data-id="{{$variation->id}}"
                                data-is-in-cart="{{(int)$variation->is_in_cart}}"
                            >
                                {{$variation->available_submit_label}}
                            </button>
                        @else
                            <strong>{{$variation->available_submit_label}}</strong>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div class="manager-area-price">
                            <p>
                                Закупочная: <span style="color: #03c; font-weight: bold;">{{$variation->price_purchase_rub_formatted}}</span>,
                                Маржа: <span style="color: #03c;">{{$variation->margin_rub_formatted}}</span>,
                                Наценка: {{$variation->price_markup}} %,
                                Заработок: {{$variation->price_income}} %
                            </p>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mob-products">
                <h3>Варианты</h3>
                @foreach($product->variations as $variation)
                <div class="over-line">
                    <div class="column">
                        <div class="product-variants__photo">
                            <a href="{{$variation->main_image_url}}" data-fancybox="variation-image-loop-mobile-{{$loop->index + 1}}">
                                <img
                                    src="{{$variation->main_image_url}}"
                                    alt="{{$variation->name}}"
                                    title="{{$variation->name}}" />
                            </a>
                            <span class="product-variants__counter">{{$loop->index + 1}}</span>
                            <a href="{{$variation->main_image_url}}" data-fancybox="variation-image-loop-mobile-{{$loop->index + 1}}" class="product-variants__zoom"></a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="block-text-product">
                            <h4 class="product-variants__title">
                                <a
                                    href="#"
                                    class="pointer link-text"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="{!! $variation->preview !!}"
                                    data-html="true"
                                >{{$variation->name}}</a>
                            </h4>
                            <div class="line-product right">
                                <span class="text-orange">{{$variation->price_retail_rub_formatted}} <span class="text-gray">/ {{$variation->unit}}</span></span>
                            </div>

                            @if($variation->is_available)
                            <div class="product-amount row-line">
                                <div class="column">
                                    <input
                                        type="number"
                                        value="1"
                                        min="1"
                                        class="
                                        product-variants__input_small
                                        js-add-to-cart-input-count-{{$variation->id}}
                                        js-input-hide-on-focus
                                        "
                                    />
                                </div>
                                <div class="column">
                                    <button
                                        class="
                                        {{ $variation->is_available_in_stock ? "red-color" : "" }}
                                        {{$variation->is_available_not_in_stock ? "color-orange" : ""}}
                                            js-add-to-cart
                                            add-basket
                                        "
                                        type="button"
                                        data-id="{{$variation->id}}"
                                        data-is-in-cart="{{(int)$variation->is_in_cart}}"
                                    >
                                        {{$variation->available_submit_label}}
                                    </button>
                                </div>
                            </div>
                            @else
                                <div class="product-amount">
                                    <strong>{{$variation->available_submit_label}}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="characteristics">

        <x-product-accessories :product="$product" class="hidden-desktop"></x-product-accessories>

        <div class="tab-container">
            <ul class="nav tabs row-line" id="product-descr-chars-tabs-mobile" role="tablist">
                <li role="presentation">
                    <a
                        href="#product-descr-tab-pane-mobile"
                        id="product-descr-tab"
                        class="active"
                        data-toggle="tab"
                        role="tab"
                        aria-controls="product-descr-tab-pane-mobile"
                        aria-selected="true"
                    >Описание</a>
                </li>
                <li role="presentation">
                    <a
                        href="#product-chars-tab-pane-mobile"
                        id="product-chars-tab"
                        class=""
                        data-toggle="tab"
                        role="tab"
                        aria-controls="product-chars-tab-pane-mobile"
                        aria-selected="false"
                    >Характеристики</a>
                </li>
            </ul>
            <div class="tab-panes" id="product-descr-chars-tab-panes-mobile">
                <div class="tab-pane active" id="product-descr-tab-pane-mobile" role="tabpanel" aria-labelledby="product-descr-tab">
                    <h3>{!! $product->name !!}</h3>
                    {!! $product->description !!}
                </div>
                <div class="tab-pane" id="product-chars-tab-pane-mobile" role="tabpanel" aria-labelledby="product-chars-tab">
                    <h3>характеристики: {!! $product->name !!}</h3>
                    <x-product-chars-props :product="$product"></x-product-chars-props>
                </div>
            </div>
        </div>


        <div class="desktop-characteristics">
            <ul class="nav nav-tabs tab-list">
                <li class="active"><a href="#tab1">Описание</a></li>
                <li><a href="#tab2">Характеристики</a></li>
            </ul>
            <div class="characteristics__content" id="tab1">
                <h3>{!! $product->name !!}</h3>
                {!! $product->description !!}
            </div>

            <x-product-accessories :product="$product"></x-product-accessories>

            <div class="characteristics__content" id="tab2">
                <h3>характеристики: {!! $product->name !!}</h3>
                <x-product-chars-props :product="$product"></x-product-chars-props>
            </div>
        </div>


        <div class="block-green">
            <p>{!! $product->name !!} в магазине, Вы можете купить {!! $product->name !!}, узнайте подробные технические характеристики и цену на {!! $product->name !!}, фотографии и отзывы посетителей помог1ут Вам определиться с покупкой, {!! $product->name !!} - закажите с доставкой на дом.</p>
        </div>

    </div>

</div>

<div class="content-sliders">
    @if($product->similar->isNotEmpty())
        <div class="slider-blocker">
            <div class="slider-blocker__header row-line row-line__between swiper-container">
                <h2 class="slider-blocker__header-title">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    {{$product->similar_name}}
                </h2>
                <div class="block-arrow">
                    <div class="swiper-button-prev btn-slider js-slider-btn-1">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next btn-slider js-slider-btn-1">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper-block">
                <div class="swiper-container js-slider-1 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach($product->similar as $item)
                            <?php /** @var \App\Models\Product\Product $item */ ?>
                            <div class="swiper-slide">
                                <div class="slider-blocker__item">
                                    <h3 class="slider-blocker__title"><a class="slider-blocker__link" href="#">{!! $item->name !!}</a></h3>
                                    <div class="slider-blocker__photo">
                                        <img src="{{$item->main_image_url}}" alt="">
                                    </div>
                                    <div class="slider-blocker__text-center">
                                        <span class="slider-blocker__cost">{{$item->price_retail_rub_formatted}}</span>
                                        <a href="{{$item->getRoute()}}" class="slider-blocker__buy">купить</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($product->related->isNotEmpty())
        <div class="slider-blocker">
            <div class="slider-blocker__header row-line row-line__between swiper-container">
                <h2 class="slider-blocker__header-title">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    {{$product->related_name}}
                </h2>
                <div class="block-arrow">
                    <div class="swiper-button-prev btn-slider js-slider-btn-2">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next btn-slider js-slider-btn-2">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper-block">
                <div class="swiper-container js-slider-2 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach($product->related as $item)
                            <?php /** @var \App\Models\Product\Product $item */ ?>
                            <div class="swiper-slide">
                                <div class="slider-blocker__item">
                                    <h3 class="slider-blocker__title"><a class="slider-blocker__link" href="#">{!! $item->name !!}</a></h3>
                                    <div class="slider-blocker__photo">
                                        <img src="{{$item->main_image_url}}" alt="">
                                    </div>
                                    <div class="slider-blocker__text-center">
                                        <span class="slider-blocker__cost">{{$item->price_retail_rub_formatted}}</span>
                                        <a href="{{$item->getRoute()}}" class="slider-blocker__buy">купить</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($product->works->isNotEmpty())
        <div class="slider-blocker">
            <div class="slider-blocker__header row-line row-line__between swiper-container">
                <h2 class="slider-blocker__header-title">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    {{$product->work_name}}
                </h2>
                <div class="block-arrow">
                    <div class="swiper-button-prev btn-slider js-slider-btn-3">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next btn-slider js-slider-btn-3">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper-block">
                <div class="swiper-container js-slider-3 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach($product->works as $item)
                            <?php /** @var \App\Models\Product\Product $item */ ?>
                            <div class="swiper-slide">
                                <div class="slider-blocker__item">
                                    <h3 class="slider-blocker__title"><a class="slider-blocker__link" href="#">{!! $item->name !!}</a></h3>
                                    <div class="slider-blocker__photo">
                                        <img src="{{$item->main_image_url}}" alt="">
                                    </div>
                                    <div class="slider-blocker__text-center">
                                        <span class="slider-blocker__cost">{{$item->price_retail_rub_formatted}}</span>
                                        <a href="{{$item->getRoute()}}" class="slider-blocker__buy">купить</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
