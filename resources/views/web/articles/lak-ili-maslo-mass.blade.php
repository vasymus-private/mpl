@extends('web.layouts.app')

@section('title')
    {{-- TODO add title --}}
@endsection

@section('wrapper-class')
    {{-- add if needed --}}
@endsection

@section('content')
    <div class="container">
        <div class="row-line no-margin">
            @include('web.layouts.sidebar-menu')

            <div class="catalog">

            </div>
        </div>
    </div>
@endsection
