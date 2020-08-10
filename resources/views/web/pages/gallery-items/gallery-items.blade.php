@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="$subtitle"></x-h1>
    <ul>
        @foreach($galleryItems as $index => $galleryItem)
            <?php /** @var \App\Models\GalleryItem $galleryItem */ ?>
            <li>
                <div><b>{{$index + 1}}</b></div>
                <div><a href="{{route("gallery.items.show", $galleryItem->slug)}}">{{$galleryItem->name}}</a></div>
                <div><img src="{{$galleryItem->getFirstMediaUrl(\App\Models\GalleryItem::MC_MAIN_IMAGE)}}" alt="{{$galleryItem->name}}" title="{{$galleryItem->description}}" width="150" height="110" /></div>
                <div><a href="{{route("gallery.items.show", $galleryItem->slug)}}">Открыть фотоальбом</a></div>
            </li>
        @endforeach
    </ul>
@endsection
