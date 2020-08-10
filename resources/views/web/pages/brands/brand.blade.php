@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \App\Models\Brand $brand */ ?>
    <x-h1 :entity="$brand"></x-h1>
    <div>
        <div>
            <img src="{{$brand->getFirstMediaUrl(\App\Models\Brand::MC_MAIN_IMAGE)}}" alt="" />
        </div>
        <div>
            <p>{{$brand->description}}</p>
        </div>
    </div>
    @include("web.pages.products.products-list", compact("products"))
@endsection
