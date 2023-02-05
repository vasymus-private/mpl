<h1>Testing</h1>
@isset($var)
{{ $var }}
@endisset

@isset($images)
    @foreach($images as $img)
        <div style="margin: 10px; max-width: 500px;"><img style="border: 1px solid black; box-sizing: border-box; max-width: 100%;" src="{{$img}}" alt=""></div>
    @endforeach
@endisset

@isset($products)
    @foreach($products as $product)
        <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
        <div>
            Id: {{$product->id}} | Name: {{$product->name}} | Ordering: {{$product->ordering}}
        </div>
    @endforeach
@endisset
