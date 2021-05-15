<?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
@extends("admin.layouts.app")

@section("content")
    <livewire:admin.show-product :product="$product" />
@endsection
