<?php /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection $products */ ?>
@php
$perPage = $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->perPage() : null;
$currentPage = $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->currentPage() : null;
@endphp
@foreach($products as $product)
    <?php /** @var \App\Models\Product\Product $product */ ?>
    @php($index = $loop->index)
    <x-product :product="$product" :index="$index" :perPage="$perPage" :currentPage="$currentPage" />
@endforeach
