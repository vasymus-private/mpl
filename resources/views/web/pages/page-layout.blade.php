@extends('web.layouts.app')

@section('wrapper-class')
    {{-- add if needed --}}
@endsection

@section('content')
    <div class="container">
        <div class="row-line no-margin">
            @include('web.layouts.sidebar-menu')

            <div class="catalog">
                @yield('page-content')
            </div>
        </div>
    </div>
@endsection
