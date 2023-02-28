<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
    <title>Testing</title>
</head>
<body>
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
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Ordering</th>
            <th>Info Prices Count</th>
            <th>Preview</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->ordering}}</td>
                <td>{{$product->info_prices_count}}</td>
                <td>{{ strip_tags(str_replace('&nbsp;', ' ', $product->preview)) }}</td>
                <td>{{ strip_tags(str_replace('&nbsp;', ' ', $product->description)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endisset
</body>
</html>
