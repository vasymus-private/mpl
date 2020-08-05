@extends('web.pages.page-layout')

@section('page-content')
    <ul>
        @foreach($brandsList as $item)
            <?php /** @var \App\Models\Brand $item */ ?>
            <li>
                <p><b><a href="{{route("brands.show", $item->slug)}}">{{$item->name}}</a></b></p>
            </li>
        @endforeach
    </ul>
@endsection
