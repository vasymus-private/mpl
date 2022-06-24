<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin panel</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    {{--<script src="https://cdn.tiny.cloud/1/dnmlt44eonw7v2yhx9o5q74y1s8y9inyqnjnw7uvjpavc6si/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
    <script src="//cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script src="https://use.fontawesome.com/3c2996233b.js" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    @livewireStyles
    <link href="{{ mix('_admin/css/app.css') }}" rel="stylesheet" />
</head>
<body>
    <div id="wrapper" class="wrapper">
        @include("admin.layouts.header")
        <main class="d-flex">
            <div id="resize-container" class="">
                @include("admin.layouts.aside", ["class" => ""])
                <div id="resizer"></div>
                <div class="" id="content">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    @livewireScripts
    <script src="{{ mix('_admin/js/app.js') }}"></script>
</body>
</html>
