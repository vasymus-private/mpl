@extends("admin.layouts.app")

@section("content")
<h1>Dashboard</h1>
<h2>Hello, {{\Illuminate\Support\Facades\Auth::user()->name}}</h2>
@endsection
