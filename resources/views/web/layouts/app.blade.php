<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo :seo="($seoArr ?? null)"/>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
{{--    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>--}}
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed+Slab:300,300i,700%7COpen+Sans:400,600,700,800&amp;subset=cyrillic"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,500,700,900&amp;subset=latin,latin-ext,cyrillic"
        rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>
</head>
<body>
@javascript([
    'cartItems' => $cartItems,
    'cartRoute' => $cartRoute,
])
@include("web.layouts.mb-menu")
@yield("mb-brands-filter")
<div class="wrapper @yield('wrapper-class')">
    @include('web.layouts.top-bar-md+')
    @include('web.layouts.top-bar-xs')
    <div class="header-sticky">
        @include('web.layouts.header')
    </div>
    <main>
        @yield('content')
    </main>
    @include('web.layouts.footer')
    @include("web.modals.contact-with-technologist")
    @include("web.modals.consent-processing-personal-data")
    @include("web.modals.success-contact-form")
    @include("web.layouts.back-to-top")
    @if(session('successContactForm'))
        <script>;window.___successContactForm = 1;</script>
    @endif
    @if(session('failedRequestTechnologist'))
        <script>;window.___failedRequestTechnologist = 1;</script>
    @endif
</div>
@include("web.templates-for-js.sidebar-menu-cart-item")
</body>
</html>
