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

@section('mb-manufacturers-filter')
    @include('web.layouts.mb-manufacturers-filter')
@endsection

@section('content')
    <div class="container">
        <div class="row-line no-margin">
    <h1>Products</h1>
        </div>
    </div>
@endsection
