@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \App\Models\Product\Product $product */ ?>
    <h2 class="content-header__title">
        <span>{{$product->name}}</span>
    </h2>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"></x-breadcrumbs>

@endsection
