<?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
@extends("admin.layouts.app")

@section("content")
    <livewire:show-product :product="$product"/>
@endsection
