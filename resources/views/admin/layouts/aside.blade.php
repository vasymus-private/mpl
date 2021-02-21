<aside id="aside" class="aside">
    <nav class="bg-light sidebar">
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
                <a
                    class="nav-link {{\Illuminate\Support\Facades\Route::is("admin.products") ? "active" : ""}}"
                    href="#products-level-1"
                    data-toggle="collapse"
                    role="button"
                    aria-expanded="false"
                    aria-controls="products-level-1"
                >
                    Каталог товаров @if(\Illuminate\Support\Facades\Route::is("admin.products"))<span class="sr-only">(current)</span>@endif
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                </a>
                <ul class="collapse list-unstyled" id="products-level-1">
                    <li><a href="#"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                    <li>
                        <a
                            href="#products-level-2"
                            data-toggle="collapse"
                            role="button"
                            aria-expanded="false"
                            aria-controls="products-level-2"
                        >Каталог 1</a>
                        <ul class="collapse list-unstyled" id="products-level-2">
                            <li><a href="#"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                            <li>
                                <a
                                    href="#products-level-3"
                                    data-toggle="collapse"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="products-level-3"
                                >Каталог 1.2</a>
                                <ul class="collapse list-unstyled" id="products-level-3">
                                    <li><a href="#"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                                    <li>
                                        <a
                                            href="#products-level-4"
                                            data-toggle="collapse"
                                            role="button"
                                            aria-expanded="false"
                                            aria-controls="products-level-4"
                                        >Каталог 1.3</a>
                                        <ul class="collapse list-unstyled" id="products-level-4">
                                            <li><a href="#"><i class="fa fa-circle" aria-hidden="true"></i> Товары</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
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
</aside>
