@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \Domain\FAQs\Models\FAQ $faq */ ?>
    <x-h1 :entity="$faq"></x-h1>
    @if($faq->created_at)<p><time datetime="{{$faq->created_at->format("Y-m-d")}}">{{$faq->created_at->format("d.m.Y")}}</time></p>@endif

    <div>
        {!! $faq->question !!}
    </div>

    <div>
        {!! $faq->answer !!}
    </div>

    @if($faq->children->isNotEmpty())
        @foreach($faq->children as $child)
            <?php /** @var \Domain\FAQs\Models\FAQ $child */ ?>
            <h2>{{$child->name}}</h2>
            @if($child->created_at)<p><time datetime="{{$child->created_at->format("Y-m-d")}}">{{$child->created_at->format("d.m.Y")}}</time></p>@endif
            <div>
                {!! $child->question !!}
            </div>
            <div>
                {!! $child->answer !!}
            </div>
        @endforeach
    @endif

    <p><a href="{{route("faq.index")}}">Вернуться к списку вопросов</a></p>
    <p><a href="{{route("ask")}}">Задать свой вопрос</a></p>

@endsection
