<?php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator|\Domain\Products\Models\Product\Product[] $products
 * @var \Domain\Products\Models\Category|null $category
 */
?>
@extends("admin.layouts.app")

@section("content")

    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
    </div>

    <h1 class="adm-title">Каталог товаров <span class="adm-fav-link"></span></h1>

    <livewire:admin.search-form current-route="admin.products.index" new-route="admin.products.create" :category="$category ?? null" />

    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input class="form-check-input position-static" type="checkbox" id="check-all" aria-label="Check all">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">ID</span></th>
                <th scope="col"><span class="main-grid-head-title">Сортировка</span></th>
                <th scope="col"><span class="main-grid-head-title">Название</span></th>
                <th scope="col"><span class="main-grid-head-title">Активность</span></th>
                <th scope="col"><span class="main-grid-head-title">Упаковка / Единица</span></th>
                <th scope="col"><span class="main-grid-head-title">Закупочная Цена</span></th>
                <th scope="col"><span class="main-grid-head-title">Розничная Цена</span></th>
                <th scope="col"><span class="main-grid-head-title">Служебная Информация</span></th>
                <th scope="col"><span class="main-grid-head-title">Наличие Товара</span></th>
                <th scope="col"><span class="main-grid-head-title">Описание Для Анонса</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class="js-product-item">
                    <td>
                        <div class="form-check">
                            <input class="form-check-input position-static" type="checkbox" aria-label="Check product with id {{$product->id}}, name {{$product->name}}">
                        </div>
                    </td>
                    <td><span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product->id)}}">{{$product->id}}</a></span></td>
                    <td><span class="main-grid-cell-content">{{$product->ordering}}</td>
                    <td><span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product->id)}}">{!! $product->name !!}</a></span></td>
                    <td><span class="main-grid-cell-content">{{$product->is_active_name}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product->unit}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product->price_purchase_formatted}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product->price_retail_formatted}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product->admin_comment}}</span></td>
                    <td><span class="main-grid-cell-content">{{$product->availability_status_name}}</span></td>
                    <td><span class="main-grid-cell-content">{!! $product->preview !!}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $products->links("admin.pagination.default") }}
@endsection
