<?php /** @var \Domain\Products\Models\Category[] $categories */ ?>
<nav class="min-vh-100 js-admin-sidbar">
    <ul class="nav pt-3">
        <li class="nav-item">
            <a href="#products" class="nav-link collapsed" data-toggle="collapse" role="button" aria-expanded="false">
                <span class="adm-arrow-icon"></span>
                <span class="adm-icon iblock_menu_icon_types"></span>
                <span class="nav-link-text">Каталог товаров</span>
            </a>
            <ul class="nav collapse" id="products">
                <li class="nav-item">
                    <a href="#products-sub" class="nav-link collapsed sub-level-1" data-toggle="collapse" role="button" aria-expanded="false">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_iblocks"></span>
                        <span class="nav-link-text">Каталог товаров</span>
                    </a>
                    <ul class="nav collapse" id="products-sub">
                        <li class="nav-item">
                            <a href="{{route("admin.products.index")}}" class="nav-link sub-level-2">
                                <span class="adm-arrow-icon-dot"></span>
                                <span class="nav-link-text">Товары</span>
                            </a>
                        </li>

                        @foreach($categories as $category)
                            <li class="nav-item">
                                <a href="#products-{{$category->id}}" class="nav-link collapsed sub-level-2" data-toggle="collapse" role="button" aria-expanded="false">
                                    <span class="adm-arrow-icon"></span>
                                    <span class="adm-icon iblock_menu_icon_sections"></span>
                                    <span class="nav-link-text">{{$category->name}}</span>
                                </a>
                                <ul class="nav collapse" id="products-{{$category->id}}">
                                    <li class="nav-item">
                                        <a href="{{route("admin.products.index", ["category_id" => $category->id])}}" class="nav-link sub-level-3">
                                            <span class="adm-arrow-icon-dot"></span>
                                            <span class="nav-link-text">Товары</span>
                                        </a>
                                    </li>
                                    @foreach($category->subcategories as $subcategory1)
                                        <li class="nav-item">
                                            <a href="#products-{{$subcategory1->id}}" class="nav-link collapsed sub-level-3" data-toggle="collapse" role="button" aria-expanded="false">
                                                <span class="adm-arrow-icon"></span>
                                                <span class="adm-icon iblock_menu_icon_sections"></span>
                                                <span class="nav-link-text">{{$subcategory1->name}}</span>
                                            </a>
                                            <ul class="nav collapse" id="products-{{$subcategory1->id}}">
                                                <li class="nav-item">
                                                    <a href="{{route("admin.products.index", ["category_id" => $subcategory1->id])}}" class="nav-link sub-level-4">
                                                        <span class="adm-arrow-icon-dot"></span>
                                                        <span class="nav-link-text">Товары</span>
                                                    </a>
                                                </li>
                                                @foreach($subcategory1->subcategories as $subcategory2)
                                                    <li class="nav-item">
                                                        <a href="#products-{{$subcategory2->id}}" class="nav-link collapsed sub-level-4" data-toggle="collapse" role="button" aria-expanded="false">
                                                            <span class="adm-arrow-icon"></span>
                                                            <span class="adm-icon iblock_menu_icon_sections"></span>
                                                            <span class="nav-link-text">{{$subcategory2->name}}</span>
                                                        </a>
                                                        <ul class="nav collapse" id="products-{{$subcategory2->id}}">
                                                            <li class="nav-item">
                                                                <a href="{{route("admin.products.index", ["category_id" => $subcategory2->id])}}" class="nav-link sub-level-5">
                                                                    <span class="adm-arrow-icon-dot"></span>
                                                                    <span class="nav-link-text">Товары</span>
                                                                </a>
                                                            </li>
                                                            @foreach($subcategory2->subcategories as $subcategory3)
                                                                <li class="nav-item">
                                                                    <a href="#products-{{$subcategory3->id}}" class="nav-link collapsed sub-level-5" data-toggle="collapse" role="button" aria-expanded="false">
                                                                        <span class="adm-arrow-icon"></span>
                                                                        <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                        <span class="nav-link-text">{{$subcategory3->name}}</span>
                                                                    </a>
                                                                    <ul class="nav collapse" id="products-{{$subcategory3->id}}">
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
            <a href="#reference" class="nav-link collapsed" data-toggle="collapse" role="button" aria-expanded="false">
                <span class="adm-arrow-icon"></span>
                <span class="adm-icon iblock_menu_icon_types"></span>
                <span class="nav-link-text">Справочники</span>
            </a>
            <ul class="nav collapse" id="reference">
                <li class="nav-item">
                    <a href="#reference-1" class="nav-link collapsed sub-level-1" data-toggle="collapse" role="button" aria-expanded="false">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_iblocks"></span>
                        <span class="nav-link-text">Производители</span>
                    </a>
                    <ul class="nav collapse" id="reference-1">
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
    </ul>
</nav>
