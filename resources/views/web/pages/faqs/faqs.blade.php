@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Вопросы и ответы'"></x-h1>

    <p><a href="{{route("ask")}}">Задайте свой вопрос</a></p>

    <div class="content__white-block">
        <?php /** @var \Illuminate\Pagination\LengthAwarePaginator $faqs */ ?>
        {{ $faqs->onEachSide(1)->links('web.pagination.default') }}

        <ul>
            @foreach($faqs as $faq)
                <?php /** @var \App\Models\FAQ $faq */ ?>
                <li>
                    <h2><a href="{{route("faq.show", $faq->slug)}}">{{$faq->name}}</a></h2>
                    <div>
                        {!! $faq->question !!}
                    </div>
                    <p><a href="{{route("faq.show", $faq->slug)}}">Подробнее</a></p>
                    @if($faq->created_at)<p><time datetime="{{$faq->created_at->format("Y-m-d")}}">{{$faq->created_at->format("d.m.Y")}}</time></p>@endif
                </li>
            @endforeach
        </ul>

        {{ $faqs->onEachSide(1)->links('web.pagination.default') }}
    </div>
@endsection
