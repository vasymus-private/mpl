<header class="header fixed-top-centered">
    <div class="container">
        <div class="row-line">
            <div class="header-column">
                <a class="logo" href="#">
                    <img alt="Parket Lux" title="Parket Lux" src="{{asset("images/logo.svg")}}">
                </a>
                <a class="toggle another-page" href="#"> </a>
            </div>
            <div class="header-search-block hidden-sm hidden-xs">
                <div class="search-block">
                    <form action="#">
                        <div class="search-field">
                            <input type="text" id="sfrm" name="q" value="" placeholder="Что вы ищете?">
                            <input name="s" type="submit" value="Поиск">
                        </div>
                    </form>
                    <div class="suggestion">Например: <a id="ssugg">Ремонт паркета</a></div>
                </div>
            </div>
            <div class="header__icon-mobile">
                <a href="#" class="basket js-manual-popover-autohide" data-toggle="popover"
                   data-content="<b>Добавлено в корзину</b>" data-placement="bottom" data-html="true"
                   data-trigger="manual" data-original-title="" title="">
                    <img src="{{asset("images/cart.svg")}}" alt="" title="">
                    <span class="count js-cart-items-count cart-items-count">0</span>
                </a>
                <a href="tel:+74957600518" class="phone-icon">
                    <img src="{{asset("images/phone.svg")}}" alt="" title="">
                </a>
            </div>
            <div class="contacts-column">
                <ul class="contacts-list">
                    <li>
                        <a class="phone" href="tel:+74953638799">+7 (495) 363 87 99</a>
                    </li>
                    <li>
                        <a class="phone" href="tel:+79153639363">+7 (915) 363 9 363</a>
                    </li>
                    <li class="text">
                        каждый день с 9:00 до 21:00
                    </li>
                    <li>
                        <a data-fancybox="show_form" data-src="#show_form" href="javascript:;" class="link">Связаться с технологом</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="menu">
            <ul>
                <li><a href="#">Как купить</a></li>
                <li><a href="#">ОПЛАТА И ДОСТАВКА</a></li>
                <li><a href="#">Контакты</a></li>
                <li><a href="#">Задайте вопрос</a></li>
                <li><a href="#">Производители</a></li>
                <li><a href="#">Видео</a></li>
                <li><a href="{{route("gallery.items.index")}}">Фото</a></li>
            </ul>
        </div>
    </div>
</header>

