@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \App\Models\Order $order */ ?>
    <x-h1 :entity="'Мой заказ №' . $order->id"></x-h1>

    <div class="content__white-block">
        <h2 class="product__title">Заказ № {{$order->id}} @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y H:i:s")}} @endif</h2>

        <x-go-back/>
    </div>
@endsection
