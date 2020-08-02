@extends('web.layouts.app')

@section('title')
    {{
        request()->subcategory3_slug->name ??
        request()->subcategory2_slug->name ??
        request()->subcategory1_slug->name ??
        request()->category_slug->name ??
        config('app.name')
    }}
@endsection

@section('wrapper-class')
    js-sidebar-slide-main-1 slideout-panel js-sidebar-slide-main-2
@endsection

@section('mb-manufacturers-filter')
    <x-mb-manufacturers-filter :productIds="$productIds"/>
@endsection

@section('content')
    <div class="container">
        <div class="row-line no-margin">
            @include('web.layouts.sidebar-menu')

            @yield('page-products-content')

            <x-sidebar-manufacturers-filter :productIds="$productIds"/>
        </div>
    </div>
@endsection
