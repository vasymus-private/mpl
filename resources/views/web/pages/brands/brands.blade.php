@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
    <x-h1 :entity="'Производители'"></x-h1>

    <div class="content__white-block">
        {{ $brandsList->onEachSide(1)->links('web.pagination.default') }}
        <div class="brands-list">
                @foreach($brandsList as $item)
                <?php /** @var \App\Models\Brand $item */ ?>
                    <div class="brands-list__item row-line">
                        <div class="brands-list__colum-left">
                            <div class="brands-list__photo">
                                <a href="{{route("brands.show", $item->slug)}}"><img src="{{$item->getFirstMediaUrl(\App\Models\Brand::MC_MAIN_IMAGE)}}" alt="" /></a>
                            </div>
                        </div>
                        <div class="brands-list__colurm-right">
                            <div class="brands-list__info">
                                <h3 class="brands-list__title"><a href="{{route("brands.show", $item->slug)}}">{{$item->name}}</a></h3>
                                <p class="brands-list__description">{{$item->preview}}</p>
                                <a href="{{route("brands.show", $item->slug)}}" class="brands-list__more">подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
        {{ $brandsList->onEachSide(1)->links('web.pagination.default') }}
    </div>
@endsection
