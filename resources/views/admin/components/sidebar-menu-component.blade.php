<?php /** @var \Domain\Products\Models\Category[] $categories */ ?>
<nav>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.home") ? "active" : ""}}" href="#">
                Доска @if(\Illuminate\Support\Facades\Route::is("admin.home"))<span class="sr-only">(current)</span>@endif
                <i class="bi bi-house-fill" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.orders") ? "active" : ""}}" href="#">
                Заказы @if(\Illuminate\Support\Facades\Route::is("admin.orders"))<span class="sr-only">(current)</span>@endif
                <i class="bi bi-card-checklist" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <x-sidebar-menu-item-category-collapser class="nav-link" :category="null"/>
            <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="null">
                <x-sidebar-menu-item-category-products-list-item :category="null"/>
                @foreach($categories as $category)
                    <li>
                        <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$category"/>
                        <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$category">
                            <x-sidebar-menu-item-category-products-list-item :category="$category"/>
                            @foreach($category->subcategories as $subcategory1)
                                <li>
                                    <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$subcategory1"/>
                                    <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$subcategory1">
                                        <x-sidebar-menu-item-category-products-list-item :category="$subcategory1"/>
                                        @foreach($subcategory1->subcategories as $subcategory2)
                                            <li>
                                                <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$subcategory2" />
                                                <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$subcategory2">
                                                    <x-sidebar-menu-item-category-products-list-item :category="$subcategory2"/>
                                                    @foreach($subcategory2->subcategories as $subcategory3)
                                                    <li>
                                                        <x-sidebar-menu-item-category-collapser class="nav-sublink" :category="$subcategory3" />
                                                        <x-sidebar-menu-item-category-submenu class="list-unstyled" :category="$subcategory3">
                                                            <x-sidebar-menu-item-category-products-list-item :category="$subcategory3" />
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
                <i class="bi bi-people-fill" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.brands") ? "active" : ""}}" href="#">
                Производители @if(\Illuminate\Support\Facades\Route::is("admin.brands"))<span class="sr-only">(current)</span>@endif
                <i class="bi bi-building" aria-hidden="true"></i>
            </a>
        </li>
    </ul>
</nav>
