@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="$subtitle"></x-h1>
    <div class="photo-gallery-wrapper">
        <ul>
            @foreach($childGalleryItems as $index => $galleryItem)
                <?php /** @var \Domain\GalleryItems\Models\GalleryItem $galleryItem */ ?>
                <li>
                    <div>
                        <a data-fancybox="gallery-1" href="{{$galleryItem->main_image_url}}" data-caption="{{$galleryItem->description}}">Увеличить</a>
                    </div>
                    <div>
                        <a data-fancybox="gallery-2" href="{{$galleryItem->main_image_url}}" data-caption="{{$galleryItem->description}}">
                            <img style="max-width: 200px;" src="{{$galleryItem->main_image_url}}" alt="{{$galleryItem->description}}" />
                        </a>
                    </div>
                    <div><p>{!! $galleryItem->description  !!}</p></div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
