<?php
/** @var \Domain\Articles\Models\Article $article */
?>

@extends('web.pages.page-article-layout')

@section('page-content')
    <article class="article-content">
        <h1>{{ $article->name }}</h1>

        <div class="article-inner">
            {!! $article->description !!}
        </div>
    </article>
@endsection
