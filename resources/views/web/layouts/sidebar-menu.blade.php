<div class="sidebar-left">
    <div class="inner-wrapper-sticky">
        <div class="sidebar-left__inner">
            @include('web.layouts.sidebar-menu-services')


            @include('web.layouts.sidebar-menu-materials')

            <!--<div class="sidebar-payment">-->
            <!--<div class="sidebar-payment__title">Любые способы оплаты</div>-->
            <!--<div class="row-line row-line__between">-->
            <!--<div class="sidebar-payment__column"><img src="images/wallet.png" alt=""></div>-->
            <!--<div class="sidebar-payment__column"><img src="images/credit-cards.png" alt=""></div>-->
            <!--<div class="sidebar-payment__column"><img src="images/bank.png" alt=""></div>-->
            <!--</div>-->
            <!--</div>-->

            @include('web.layouts.sidebar-menu-cart')


            <div class="sidebar-left__fav">
                <a href="#" class="sidebar-left__fav-link">Отложенные товары</a>
                (<span id="fav_items_count" class="sidebar-left__fav-count">0</span>)
            </div>


            <div class="watched-block">
                <h4 class="watched-block__title">Вы смотрели</h4>
                <div class="watched-block__body">
                    <div class="row-line">
                        <div class="column">
                            <a href="#">
                                <img width="40" height="40" align="left" src="{{asset('images/big-photo.jpg')}}"
                                     style="margin-right: 10px;" alt="Дуб &quot;АртПаркет&quot; - штучный паркет">
                            </a>
                        </div>
                        <div class="column">
                            <div class="product-special">
                                <a title="Дуб &quot;АртПаркет&quot; - штучный паркет" href="#">Дуб "АртПаркет" - штучный паркет</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
