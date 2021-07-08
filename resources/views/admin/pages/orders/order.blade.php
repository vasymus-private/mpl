<?php
/**
 * @var \Domain\Orders\Models\Order $order
 */
?>

@extends("admin.layouts.app")

@section("content")

    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
    </div>

    <livewire:admin.show-order.show-order :item="$order" />

@endsection
