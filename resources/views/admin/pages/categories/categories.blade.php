<?php /** @var \Illuminate\Pagination\LengthAwarePaginator|\Domain\Products\Models\Category[] $categories */ ?>
@extends("admin.layouts.app")

@section("content")
    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
    </div>

    <h1 class="adm-title">Каталог товаров: Разделы <span class="adm-fav-link"></span></h1>

@endsection
