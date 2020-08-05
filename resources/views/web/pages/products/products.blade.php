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
        <button class="btn-sort js-sidebar-slide-toggle-2">Сортировать</button>

        <?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
        {{ $products->onEachSide(1)->links('web.pagination.default') }}

        @include("web.pages.products.products-list", compact("products"))

        {{ $products->onEachSide(1)->links('web.pagination.default') }}
    </div>
@endsection
