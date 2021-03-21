<?php /** @var \Domain\Products\Models\Category[] $categories */ ?>
<nav>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.home") ? "active" : ""}}" href="#">
                Доска @if(\Illuminate\Support\Facades\Route::is("admin.home"))<span class="sr-only">(current)</span>@endif
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.orders") ? "active" : ""}}" href="#">
                Заказы @if(\Illuminate\Support\Facades\Route::is("admin.orders"))<span class="sr-only">(current)</span>@endif
                <i class="fa fa-file" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <x-sidebar-menu-item-category-collapser class="nav-link" :category="null"/>
            <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="null">
                <li><a href="{{route("admin.products.index")}}"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                @foreach($categories as $category)
                    <li>
                        <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$category"/>
                        <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$category">
                            <li><a href="{{route("admin.products.index", ["category_id" => $category->id])}}"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                            @foreach($category->subcategories as $subcategory1)
                                <li>
                                    <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$subcategory1"/>
                                    <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$subcategory1">
                                        <li><a href="{{route("admin.products.index", ["category_id" => $subcategory1->id])}}"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                                        @foreach($subcategory1->subcategories as $subcategory2)
                                            <li>
                                                <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$subcategory2" />
                                                <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$subcategory2">
                                                    <li><a href="{{route("admin.products.index", ["category_id" => $subcategory2->id])}}"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                                                    @foreach($subcategory2->subcategories as $subcategory3)
                                                    <li>
                                                        <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$subcategory3" />
                                                        <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$subcategory3">
                                                            <li><a href="{{route("admin.products.index", ["category_id" => $subcategory3->id])}}"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                                                        </x-sidebar-menu-item-category-submenu>
                                                    </li>
                                                    @endforeach
                                                </x-sidebar-menu-item-category-submenu>
                                            </li>
                                        @endforeach
                                    </x-sidebar-menu-item-category-submenu>
                                </li>
                            @endforeach
                        </x-sidebar-menu-item-category-submenu>
                    </li>
                @endforeach
            </x-sidebar-menu-item-category-submenu>
        </li>
        <li class="nav-item">
            <a class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.users") ? "active" : ""}}" href="#" data-toggle="collapse" >
                Клиенты @if(\Illuminate\Support\Facades\Route::is("admin.users"))<span class="sr-only">(current)</span>@endif
                <i class="fa fa-users" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.brands") ? "active" : ""}}" href="#">
                Производители @if(\Illuminate\Support\Facades\Route::is("admin.brands"))<span class="sr-only">(current)</span>@endif
                <i class="fa fa-industry" aria-hidden="true"></i>
            </a>
        </li>
    </ul>
</nav>
