@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="$subtitle"></x-h1>
    <ul>
        @foreach($childGalleryItems as $index => $galleryItem)
            <?php /** @var \App\Models\GalleryItem $galleryItem */ ?>
            <li>
                <div>
                    <a data-fancybox="gallery-1" href="{{$galleryItem->getFirstMediaUrl(\App\Models\GalleryItem::MC_MAIN_IMAGE)}}" alt="{{$galleryItem->description}}" data-caption="{{$galleryItem->description}}">Увеличить</a>
                </div>
                <div>
                    <a data-fancybox="gallery-2" href="{{$galleryItem->getFirstMediaUrl(\App\Models\GalleryItem::MC_MAIN_IMAGE)}}" alt="{{$galleryItem->description}}" data-caption="{{$galleryItem->description}}">
                        <img style="max-width: 200px;" src="{{$galleryItem->getFirstMediaUrl(\App\Models\GalleryItem::MC_MAIN_IMAGE)}}" alt="{{$galleryItem->description}}" />
                    </a>
                </div>
                <div><p>{!! $galleryItem->description  !!}</p></div>
            </li>
        @endforeach
    </ul>
@endsection
