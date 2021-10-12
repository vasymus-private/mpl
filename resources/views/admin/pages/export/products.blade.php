<?php
/**
 * @var \Domain\Common\Models\CustomMedia[] $mediaItems
 */
?>

@extends("admin.layouts.app")

@section("content")

    <div class="breadcrumbs">
        <a href="{{route('admin.home')}}" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </a>
    </div>

    <h1 class="adm-title">Список архивов с экспортом товаров <span class="adm-fav-link"></span></h1>
    @if(session()->has('message'))
        <div class="h1 text-success">{{session()->get('message')}}</div>
    @endif

    <form action="{{route(\App\Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_STORE)}}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-12">
                <button type="submit" class="btn btn-info">Экспортировать товары</button>
            </div>
        </div>
    </form>

    <div>
        <div class="admin-edit-variations">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Будет удалён</th>
                    <th scope="col">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($mediaItems as $media)
                        <tr class="js-product-item">
                            <td><span class="main-grid-cell-content">{{$media->id}}</span></td>
                            <td>
                                <span class="main-grid-cell-content">
                                    <a href="{{route(\App\Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW, $media->id)}}">{{$media->file_name}}</a>
                                </span>
                            </td>
                            <td>
                                <span class="main-grid-cell-content">
                                    {{$media->getCustomProperty('deleteTime')}}
                                </span>
                            </td>
                            <td>
                                <button form="delete-export-products-{{$media->id}}" class="btn btn-danger">Удалить</button>
                                <form id="delete-export-products-{{$media->id}}" action="{{route(\App\Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE, $media->id)}}" class="d-none" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
