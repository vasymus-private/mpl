@extends('web.pages.page-products-layout')

@section('page-products-content')
    <div class="catalog">
        <h2 class="content-header__title">
            @if($subtitle)<span>{{$subtitle}}</span>@else<span style="padding: 0">&nbsp;</span>@endif
        </h2>
        @if(count($breadcrumbs))
            <div class="row-line row-line__center breadcrumbs">
                @foreach($breadcrumbs as $breadcrumb)
                    @if(!$loop->last)
                        <a class="breadcrumbs__link" href="{{$breadcrumb['href']}}">{{$breadcrumb['name']}}</a>
                    @else
                        <span class="breadcrumbs__link">{{$breadcrumb["name"]}}</span>
                    @endif
                @endforeach
            </div>
        @endif
        <button class="btn-sort">Сортировать</button>

        <?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
        {{ $products->onEachSide(1)->links('web.pagination.default') }}

        @foreach($products as $product)
            <?php /** @var \App\Models\Product\Product $product */ ?>
            <div class="catalog__post">
                <h3 class="catalog__title"><a href="#" class="catalog__link">{!! $product->name !!}</a></h3>
                <div class="row-line">
                    <div class="column-photo">
                        <div class="catalog__photo">
                            @php $src = $product->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE);  @endphp
                            <a href="#"><img style="max-width: 120px;" src="{{$src}}" alt="{!! $product->name !!}" class="catalog__image"></a>
                        </div>
                        <div class="put-off-block">
                            <a href="#" class="put-off-block__link put-off-block__link--active">
                                <i class="fa fa-bookmark" aria-hidden="true"></i>
                                Отложить
                            </a>
                        </div>
                    </div>
                    <div class="column-text">
                        {!! $product->preview !!}

                        <div class="catalog__product-variants">
                            <a href="#" class="catalog__variant-link">
                                <span class="desktop-visible">Варианты этого товара <img src="{{asset('images/variants-arrow.png')}}" width="20" height="14"></span>
                                <span class="mob-visible">Подробнее</span>
                            </a>
                        </div>
                    </div>
                    <div class="column-price-block">
                        <span class="catalog__price-title">{{$product->price_name}}:</span>
                        <span class="catalog__price">{{$product->price_retail}} {{\App\Models\Currency::getFormatedName($product->price_retail_currency_id)}} <span class="gray-color"> / {{$product->unit}}</span>
                    </span>
                        @if($product->is_available)
                            <span class="catalog__status catalog__status--available">Есть в наличии</span>
                        @else
                            <span class="catalog__status catalog__status--not-available">Нет в наличии</span>
                        @endif

                        <button type="button" class="catalog__addToCard">Купить</button>

                        @if($product->infoPrices->isNotEmpty())
                            @foreach($product->infoPrices->take(3) as $infoPrice)
                                <?php /** @var \App\Models\InformationalPrice $infoPrice */ ?>
                                <div class="price-bottom">
                                    <div class="price-bottom__text">{{$infoPrice->name}}</div>
                                    <div class="price-bottom__currency">{{$infoPrice->price}}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="column-price-mobile">
                        <div class="column">
                            <span class="catalog__price">{{$product->price_retail}} {{\App\Models\Currency::getFormatedName($product->price_retail_currency_id)}}<span class="gray-color"> / {{$product->unit}}</span></span>
                        </div>
                        <div class="column">
                            <button type="button" class="catalog__addToCard">Купить</button>
                        </div>
                    </div>
                </div>
                <div class="catalog__number">{{$products->perPage() * ($products->currentPage() - 1) + $loop->index + 1}}</div>
            </div>
        @endforeach

        {{ $products->onEachSide(1)->links('web.pagination.default') }}
    </div>
@endsection
