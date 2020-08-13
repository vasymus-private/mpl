@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \App\Models\Product\Product $product */ ?>
    <?php /** @var \App\Services\Breadcrumbs\BreadcrumbDTO[] $breadcrumbs */ ?>
    <x-h1 :entity="$product"></x-h1>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"></x-breadcrumbs>
    <a href="{{\Illuminate\Support\Arr::last($breadcrumbs)->url ?? null}}">В список товаров</a>
    <x-product :product="$product" :asideIds="$asideIds"></x-product>
@endsection
