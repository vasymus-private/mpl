<?php /** @var \Domain\Products\Models\Category $category */ ?>
@extends("admin.layouts.app")

@section("content")
    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
        <span class="breadcrumbs__item">
            <span class="breadcrumbs__arrow"></span>
        </span>
        <a href="{{route('admin.category.index')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Каталог категорий</span>
        </a>
    </div>

    <livewire:admin.show-category :category="$category" />
@endsection
