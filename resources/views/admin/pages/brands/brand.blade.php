<?php /** @var \Domain\Products\Models\Brand $brand */ ?>
@extends("admin.layouts.app")

@section("content")
    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
        <span class="breadcrumbs__item">
            <span class="breadcrumbs__arrow"></span>
        </span>
        <a href="{{route('admin.brands.index')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Производители</span>
        </a>
    </div>

    <livewire:admin.show-brand :brand="$brand" />
@endsection
