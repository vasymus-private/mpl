<?php /** @var \Illuminate\Pagination\LengthAwarePaginator|\Domain\Products\Models\Product\Product[] $products */ ?>
@extends("admin.layouts.app")

@section("content")
    <div class="breadcrumbs">
        <a href="#" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
        <span class="breadcrumbs__item">
            <span class="breadcrumbs__arrow"></span>
        </span>
        <a href="#" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Контент</span>
        </a>
        <span class="breadcrumbs__item">
            <span class="breadcrumbs__arrow"></span>
        </span>
        <a href="#" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Каталог товаров</span>
        </a>
    </div>
    <h1 class="adm-title">Каталог товаров <span class="adm-fav-link"></span></h1>
    <form action="{{route("admin.products.index")}}" method="GET">
        <div class="search form-group row">
            <div class="col-xs-12 col-sm-10">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control js-search-input" placeholder="Фильтр + поиск" aria-label="Фильтр + поиск" aria-describedby="search-button">
                    <div class="input-group-append">
                        <button class="btn-outline-secondary js-search-clear" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <button class="btn-outline-secondary search-icon" type="submit" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2">
                <div class="dropdown">
                    <button class="btn btn-add btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Создать товар
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route("admin.products.create")}}">Товар без вариантов</a>
                        <a class="dropdown-item" href="{{route("admin.products.create")}}">Товар с вариантами</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
