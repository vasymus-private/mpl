<h1>Testing</h1>
@isset($var)
{{ $var }}
@endisset

@csrf
<p>{!! captcha_img() !!}</p>
<p>{{ csrf_token() }}</p>

@isset($images)
    @foreach($images as $img)
        <div style="margin: 10px; max-width: 500px;"><img style="border: 1px solid black; box-sizing: border-box; max-width: 100%;" src="{{$img}}" alt=""></div>
    @endforeach
@endisset
