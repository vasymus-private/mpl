<?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
@extends("admin.layouts.app")

@section("content")
    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
        <span class="breadcrumbs__item">
            <span class="breadcrumbs__arrow"></span>
        </span>
        <a href="{{route('admin.products.index')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Каталог товаров</span>
        </a>
    </div>

    <livewire:admin.show-product :item="$product" />
@endsection
