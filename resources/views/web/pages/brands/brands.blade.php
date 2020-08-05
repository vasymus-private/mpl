@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
    {{ $brandsList->onEachSide(1)->links('web.pagination.default') }}
    <ul>
        @foreach($brandsList as $item)
            <?php /** @var \App\Models\Brand $item */ ?>
            <li>
                <div>
                    <div>
                        <img width="104" height="49" src="{{$item->getFirstMediaUrl(\App\Models\Brand::MC_MAIN_IMAGE)}}" alt=""/>
                    </div>
                    <div>
                        <p><b><a href="{{route("brands.show", $item->slug)}}">{{$item->name}}</a></b></p>
                        <p>{{$item->preview}}</p>
                        <p><a href="{{route("brands.show", $item->slug)}}">Подробнее</a></p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $brandsList->onEachSide(1)->links('web.pagination.default') }}
@endsection
