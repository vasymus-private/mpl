<div class="sidebar-left">
    <div class="inner-wrapper-sticky">
        <div class="sidebar-left__inner">
            <x-sidebar-menu-services />

            <x-sidebar-menu-materials />

            <!--<div class="sidebar-payment">-->
            <!--<div class="sidebar-payment__title">Любые способы оплаты</div>-->
            <!--<div class="row-line row-line__between">-->
            <!--<div class="sidebar-payment__column"><img src="{{asset("images/wallet.png")}}" alt=""></div>-->
            <!--<div class="sidebar-payment__column"><img src="{{asset("images/credit-cards.png")}}" alt=""></div>-->
            <!--<div class="sidebar-payment__column"><img src="{{asset("images/bank.png")}}" alt=""></div>-->
            <!--</div>-->
            <!--</div>-->

            <x-sidebar-menu-cart />

            <x-sidebar-menu-favourites-count />

            <x-sidebar-menu-viewed />

            <ul class="sidebar-list-block">
                <li class="sidebar-list-block__item">
                    <p class="sidebar-list-block__text">
                        <img alt="новинка" src="{{asset('images/delivery_car.gif')}}" align="left">
                        <span>Доставляем интернет заказы в регионы России</span>
                    </p>
                </li>
                <li class="sidebar-list-block__item">
                    <p class="sidebar-list-block__text">
                        <img alt="Оплата заказа" src="{{asset('images/pay_digital.gif')}}" align="left">
                        <span>Вы можете оплатить заказ курьеру наличными или через банк.</span>
                    </p>
                </li>
            </ul>
        </div>
    </div>
</div>
