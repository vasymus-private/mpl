<?php
/**
 * @var \Domain\Products\Models\Category[] $categories
 * @var \Closure $isActive @see {@link \App\View\Components\Admin\SidebarMenuComponent::isActive()}
 */
?>
<nav class="min-vh-100 js-admin-sidbar">
    <ul class="nav pt-3">
        <li class="nav-item">
            <a href="#categories" class="nav-link {{$isActive('categories', null) ? '' : 'collapsed'}}" data-toggle="collapse" role="button" aria-expanded="{{$isActive('categories', null) ? 'true' : 'false'}}">
                <span class="adm-arrow-icon"></span>
                <span class="adm-icon iblock_menu_icon_types"></span>
                <span class="nav-link-text">Каталог товаров</span>
            </a>
            <ul class="nav collapse {{$isActive('categories', null) ? 'show' : ''}}" id="categories">
                <li class="nav-item">
                    <a href="#categories-sub" class="nav-link {{$isActive('categories-sub', null) ? '' : 'collapsed'}} sub-level-1" data-toggle="collapse" role="button" aria-expanded="{{$isActive('categories-sub', null) ? 'true' : 'false'}}">
                        <span class="adm-arrow-icon"></span>
                        <span class="d-flex align-items-center justify-content-center js-navigate-categories" data-route="{{route('admin.categories.index')}}">
                            <span class="adm-icon iblock_menu_icon_iblocks"></span>
                            <span class="nav-link-text">Каталог товаров</span>
                        </span>
                    </a>
                    <ul class="nav collapse {{$isActive('categories-sub', null) ? 'show' : ''}}" id="categories-sub">
                        <li class="nav-item">
                            <a href="{{route("admin.products.index")}}" class="nav-link sub-level-2">
                                <span class="adm-arrow-icon-dot"></span>
                                <span class="nav-link-text">Товары</span>
                            </a>
                        </li>

                        @foreach($categories as $category)
                            <li class="nav-item">
                                <a href="#categories-{{$category->id}}" class="nav-link {{$isActive('categories', $category->id) ? '' : 'collapsed'}} sub-level-2" data-toggle="collapse" role="button" aria-expanded="{{$isActive('categories', $category->id) ? 'true' : 'false'}}">
                                    <span class="adm-arrow-icon"></span>
                                    <span class="d-flex align-items-center justify-content-center js-navigate-categories" data-route="{{route('admin.categories.index', ['category_id' => $category->id])}}">
                                        <span class="adm-icon iblock_menu_icon_sections"></span>
                                        <span class="nav-link-text">{{$category->name}}</span>
                                    </span>
                                </a>
                                <ul class="nav collapse {{$isActive('categories', $category->id) ? 'show' : ''}}" id="categories-{{$category->id}}">
                                    <li class="nav-item">
                                        <a href="{{route("admin.products.index", ["category_id" => $category->id])}}" class="nav-link sub-level-3">
                                            <span class="adm-arrow-icon-dot"></span>
                                            <span class="nav-link-text">Товары</span>
                                        </a>
                                    </li>
                                    @foreach($category->subcategories as $subcategory1)
                                        <li class="nav-item">
                                            <a href="#categories-{{$subcategory1->id}}" class="nav-link {{$isActive('categories', $subcategory1->id) ? '' : 'collapsed'}} sub-level-3" data-toggle="collapse" role="button" aria-expanded="{{$isActive('categories', $subcategory1->id) ? 'true' : 'false'}}">
                                                <span class="adm-arrow-icon"></span>
                                                <span class="d-flex align-items-center justify-content-center js-navigate-categories" data-route="{{route('admin.categories.index', ['category_id' => $subcategory1->id])}}">
                                                    <span class="adm-icon iblock_menu_icon_sections"></span>
                                                    <span class="nav-link-text">{{$subcategory1->name}}</span>
                                                </span>
                                            </a>
                                            <ul class="nav collapse {{$isActive('categories', $subcategory1->id) ? 'show' : ''}}" id="categories-{{$subcategory1->id}}">
                                                <li class="nav-item">
                                                    <a href="{{route("admin.products.index", ["category_id" => $subcategory1->id])}}" class="nav-link sub-level-4">
                                                        <span class="adm-arrow-icon-dot"></span>
                                                        <span class="nav-link-text">Товары</span>
                                                    </a>
                                                </li>
                                                @foreach($subcategory1->subcategories as $subcategory2)
                                                    <li class="nav-item">
                                                        <a href="#categories-{{$subcategory2->id}}" class="nav-link {{$isActive('categories', $subcategory2->id) ? '' : 'collapsed'}} sub-level-4" data-toggle="collapse" role="button" aria-expanded="{{$isActive('categories', $subcategory2->id) ? 'true' : 'false'}}">
                                                            <span class="adm-arrow-icon"></span>
                                                            <span class="d-flex align-items-center justify-content-center js-navigate-categories" data-route="{{route('admin.categories.index', ['category_id' => $subcategory2->id])}}">
                                                                <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                <span class="nav-link-text">{{$subcategory2->name}}</span>
                                                            </span>
                                                        </a>
                                                        <ul class="nav collapse {{$isActive('categories', $subcategory2->id) ? 'show' : ''}}" id="categories-{{$subcategory2->id}}">
                                                            <li class="nav-item">
                                                                <a href="{{route("admin.products.index", ["category_id" => $subcategory2->id])}}" class="nav-link sub-level-5">
                                                                    <span class="adm-arrow-icon-dot"></span>
                                                                    <span class="nav-link-text">Товары</span>
                                                                </a>
                                                            </li>
                                                            @foreach($subcategory2->subcategories as $subcategory3)
                                                                <li class="nav-item">
                                                                    <a href="#categories-{{$subcategory3->id}}" class="nav-link {{$isActive('categories', $subcategory3->id) ? '' : 'collapsed'}} sub-level-5" data-toggle="collapse" role="button" aria-expanded="{{$isActive('categories', $subcategory3->id) ? 'true' : 'false'}}">
                                                                        <span class="adm-arrow-icon"></span>
                                                                        <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                        <span class="nav-link-text">{{$subcategory3->name}}</span>
                                                                    </a>
                                                                    <ul class="nav collapse {{$isActive('categories', $subcategory3->id) ? 'show' : ''}}" id="categories-{{$subcategory3->id}}">
                                                                        <li class="nav-item">
                                                                            <a href="{{route("admin.products.index", ["category_id" => $subcategory3->id])}}" class="nav-link sub-level-6">
                                                                                <span class="adm-arrow-icon-dot"></span>
                                                                                <span class="nav-link-text">Товары</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#reference" class="nav-link {{$isActive('reference', null) ? '' : 'collapsed'}}" data-toggle="collapse" role="button" aria-expanded="{{$isActive('reference', null) ? 'true' : 'false'}}">
                <span class="adm-arrow-icon"></span>
                <span class="adm-icon iblock_menu_icon_types"></span>
                <span class="nav-link-text">Справочники</span>
            </a>
            <ul class="nav collapse {{$isActive('reference', null) ? 'show' : ''}}" id="reference">
                <li class="nav-item">
                    <a href="#reference-1" class="nav-link {{$isActive('reference-brands', null) ? '' : 'collapsed'}} sub-level-1" data-toggle="collapse" role="button" aria-expanded="{{$isActive('reference-brands', null) ? 'true' : 'false'}}">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_iblocks"></span>
                        <span class="nav-link-text">Производители</span>
                    </a>
                    <ul class="nav collapse {{$isActive('reference-brands', null) ? 'show' : ''}}" id="reference-1">
                        <li class="nav-item">
                            <a href="{{route('admin.brands.index')}}" class="nav-link sub-level-2">
                                <span class="adm-arrow-icon-dot"></span>
                                <span class="nav-link-text">Элементы</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#reference-2" class="nav-link collapsed sub-level-1" data-toggle="collapse" role="button" aria-expanded="false">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_iblocks"></span>
                        <span class="nav-link-text">Отзывы о товарах и услугах</span>
                    </a>
                    <ul class="nav collapse" id="reference-2">
                        <li class="nav-item">
                            <a href="#" class="nav-link sub-level-2">
                                <span class="adm-arrow-icon-dot"></span>
                                <span class="nav-link-text">Элементы</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#reference-3" class="nav-link collapsed sub-level-1" data-toggle="collapse" role="button" aria-expanded="false">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_iblocks"></span>
                        <span class="nav-link-text">Вопрос-ответ</span>
                    </a>
                    <ul class="nav collapse" id="reference-3">
                        <li class="nav-item">
                            <a href="#" class="nav-link sub-level-2">
                                <span class="adm-arrow-icon-dot"></span>
                                <span class="nav-link-text">Элементы</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#reference-4" class="nav-link collapsed sub-level-1" data-toggle="collapse" role="button" aria-expanded="false">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_iblocks"></span>
                        <span class="nav-link-text">Контактные формы</span>
                    </a>
                    <ul class="nav collapse" id="reference-4">
                        <li class="nav-item">
                            <a href="#" class="nav-link sub-level-2">
                                <span class="adm-arrow-icon-dot"></span>
                                <span class="nav-link-text">Элементы</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#highload" class="nav-link collapsed" data-toggle="collapse" role="button" aria-expanded="false">
                <span class="adm-arrow-icon"></span>
                <span class="adm-icon highloadblock_menu_icon"></span>
                <span class="nav-link-text">Highload-блоки</span>
            </a>
            <ul class="nav collapse" id="highload">
                <li class="nav-item">
                    <a href="#" class="nav-link sub-level-1">
                        <span class="adm-arrow-icon-dot"></span>
                        <span class="nav-link-text">Blacklist</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_INDEX)}}" class="nav-link">
                <span style="width: 20px;"></span>
                <span class="adm-icon iblock_menu_icon_types"></span>
                <span class="nav-link-text">Заказы</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route(\App\Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX)}}" class="nav-link">
                <span style="width: 20px;"></span>
                <span class="adm-icon iblock_menu_icon_types"></span>
                <span class="nav-link-text">Экспорт</span>
            </a>
        </li>
    </ul>
</nav>
