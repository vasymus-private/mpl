<?php /** @var \App\Models\Product\Product $product */ ?>
{{-- Название --}}
<h2>{!! $product->name !!}</h2>

{{-- Кнопка "отложить" --}}
<div class="put-off-block">
    <a href="#" data-id="{{$product->id}}" class="js-put-aside put-off-block__link {{in_array($product->id, $asideIds) ? "put-off-block__link--active" : ""}}">
        <i class="fa fa-bookmark" aria-hidden="true"></i>
        Отложить
    </a>
</div>


{{-- Дропдаун / просто ссылка "Скачать инструкции" --}}
@if(count($instructions()))
<div>
    @if(count($instructions()) === 1)
        <a target="_blank" href="{{$instructions()->first()->getFullUrl()}}">Скачать инструкции</a>
    @else
        <div class="dropdown">
            <a class="" href="#" role="button" id="js-product-files" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Скачать инструкции
            </a>

            <div class="dropdown-menu" aria-labelledby="js-product-files">
                @foreach($instructions() as $instruction)
                    <?php /** @var \Spatie\MediaLibrary\Models\Media $instruction */ ?>
                    <a class="dropdown-item" target="_blank" href="{{$instruction->getFullUrl()}}">{{$instruction->name}}</a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endif


{{-- Главная картинка товара --}}
<style>.product-main-image-wrapper {max-width: 300px;} </style>
<div class="product-main-image-wrapper">
    <a href="{{$mainImage()}}" data-fancybox="images"><img src="{{$mainImage()}}" alt="{{$product->name}}" title="{{$product->name}}" /></a>
</div>


{{-- thumbnails картинок --}}
@if(count($images()))
<style>.product-images-view svg {width: 20px; height: 20px; color: #000;} .product-images-wrapper .product-images {max-width:30px;} </style>
<a class="product-images-view" href="{{$images()->first()->getFullUrl()}}" data-fancybox="images">
    Фото ({{$images()->count()}})
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="currentColor" d="M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z"></path>
    </svg>
</a>
<div class="product-images-wrapper">
    @foreach($images() as $image)
        <?php /** @var \Spatie\MediaLibrary\Models\Media $image */ ?>
        <a href="{{$image->getFullUrl()}}" data-fancybox="images"><img class="product-images" src="{{$image->getFullUrl()}}" alt=""  /></a>
    @endforeach
</div>
@endif


{{-- Производитель --}}
@if($product->brand)
<div>
    <p><a href="{{route("brands.show", $product->brand->slug)}}">Производитель</a></p>
    <p><img style="max-width: 150px;" src="{{$product->brand->getFirstMediaUrl(\App\Models\Brand::MC_MAIN_IMAGE)}}" alt="" /></p>
</div>
@endif


{{-- Если товар без вариантов --}}
@if($product->variations->isEmpty())
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
@if($product->variations->isNotEmpty())
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
