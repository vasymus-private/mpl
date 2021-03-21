<?php /** @var \Illuminate\Pagination\LengthAwarePaginator|\Domain\Products\Models\Product\Product[] $products */ ?>
@extends("admin.layouts.app")

@section("content")
    <form action="{{route("admin.products.index")}}" method="GET">
        <div class="form-group row">
            <div class="col-xs-12 col-sm-9">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control js-search-input" placeholder="Поиск" aria-label="Поиск" aria-describedby="search-button">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <button class="btn btn-outline-secondary js-search-clear" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Создать
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Товар без вариантов</a>
                        <a class="dropdown-item" href="#">Товар с вариантами</a>
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
                <th scope="col">ID</th>
                <th scope="col">Сортировка</th>
                <th scope="col">Название</th>
                <th scope="col">Активность</th>
                <th scope="col">Упаковка / Единица</th>
                <th scope="col">Закупочная Цена</th>
                <th scope="col">Розничная Цена</th>
                <th scope="col">Служебная Информация</th>
                <th scope="col">Наличие Товара</th>
                <th scope="col">Описание Для Анонса</th>
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
                    <td><a href="{{route("admin.products.show", $product->slug)}}">{{$product->id}}</a></td>
                    <td>{{$product->ordering}}</td>
                    <td><a href="{{route("admin.products.show", $product->slug)}}">{!! $product->name !!}</a></td>
                    <td>{{$product->is_active_name}}</td>
                    <td>{{$product->unit}}</td>
                    <td>{{$product->price_purchase_formatted}}</td>
                    <td>{{$product->price_retail_formatted}}</td>
                    <td>{{$product->admin_comment}}</td>
                    <td>{{$product->availability_status_name}}</td>
                    <td>{!! $product->preview !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
