<?php
/**
 * @var array[] $products @see {@link \Domain\Products\DTOs\Admin\CategoryProductItemDTO} @see {@link \App\Http\Livewire\Admin\ShowCategory::$products}
 */
?>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Активность</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td><a href="{{route('admin.products.edit', $product['id'])}}" target="_blank">{{$product['id']}}</a></td>
                    <td><a href="{{route('admin.products.edit', $product['id'])}}" target="_blank">{!! $product['name'] !!}</a></td>
                    <td>{{$product['is_active_name']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
