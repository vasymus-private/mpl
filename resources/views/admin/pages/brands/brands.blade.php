<?php /** @var \Illuminate\Pagination\LengthAwarePaginator|\Domain\Products\Models\Brand[] $brands */ ?>

@extends("admin.layouts.app")

@section("content")

    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
    </div>

    <h1 class="adm-title">Производители <span class="adm-fav-link"></span></h1>

    <form action="{{route("admin.brands.index")}}" method="GET">
        <div class="search form-group row">
            <div class="col-xs-12 col-sm-10">
                <div class="input-group mb-3">
                    <input type="text" name="search" value="{{request('search', '')}}" class="form-control js-search-input" placeholder="Фильтр + поиск" aria-label="Фильтр + поиск" aria-describedby="search-button">
                    <div class="input-group-append">
                        <button class="btn-outline-secondary js-search-clear" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <button class="btn-outline-secondary search-icon" type="submit" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2">
                <div class="dropdown">
                    <a href="{{route('admin.brands.create')}}" class="btn btn-add btn-secondary">
                        Добавить производителя
                    </a>
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
                <th scope="col"><span class="main-grid-head-title">Описание Для Анонса</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($brands as $brand)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input position-static" type="checkbox" aria-label="Check product with id {{$brand->id}}, name {{$brand->name}}">
                        </div>
                    </td>
                    <td><span class="main-grid-cell-content"><a href="{{route("admin.brands.edit", $brand->id)}}">{{$brand->id}}</a></span></td>
                    <td><span class="main-grid-cell-content">{{$brand->ordering}}</td>
                    <td><span class="main-grid-cell-content"><a href="{{route("admin.brands.edit", $brand->id)}}">{!! $brand->name !!}</a></span></td>
                    <td><span class="main-grid-cell-content">{!! $brand->preview !!}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $brands->links("admin.pagination.default") }}

@endsection
