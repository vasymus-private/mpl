@extends('web.pages.page-products-layout')

@section('page-products-content')
    <h2 class="content-header__title">
        @if($subtitle)<span>{{$subtitle}}</span>@else<span style="padding: 0">&nbsp;</span>@endif
    </h2>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"></x-breadcrumbs>
    <button class="btn-sort js-sidebar-slide-toggle-2">Сортировать</button>

    <?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
    {{ $products->onEachSide(1)->links('web.pagination.default') }}

    @include("web.pages.products.products-list", compact("products"))

    {{ $products->onEachSide(1)->links('web.pagination.default') }}
@endsection
