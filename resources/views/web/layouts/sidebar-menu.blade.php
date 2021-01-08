<?php
/**
 * @see \App\View\Composers\ProfileComposer::compose()
 * @var int $asideCount
 * */
?>
<div class="sidebar-left js-sticky-sidebar">
    <div class="inner-wrapper-sticky js-inner-wrapper-sticky">
        <div class="sidebar-left__inner">
            <x-sidebar-menu-services />

            <x-sidebar-menu-materials />

            <!--<div class="sidebar-payment">-->
            <!--<div class="sidebar-payment__title">Любые способы оплаты</div>-->
            <!--<div class="row-line row-line__between">-->
            <!--<div class="sidebar-payment__column"><img src="{{asset("images//wallet.png")}}" alt=""></div>-->
            <!--<div class="sidebar-payment__column"><img src="{{asset("images//credit-cards.png")}}" alt=""></div>-->
            <!--<div class="sidebar-payment__column"><img src="{{asset("images//bank.png")}}" alt=""></div>-->
            <!--</div>-->
            <!--</div>-->

            <x-sidebar-menu-cart />

            <div class="sidebar-left__fav">
                <a href="{{route('aside')}}" class="sidebar-left__fav-link">Отложенные товары</a>
                (<span class="sidebar-left__fav-count js-aside-items-count">{{$asideCount}}</span>)
            </div>


            <x-sidebar-menu-viewed />

            <ul class="sidebar-list-block">
                <li class="sidebar-list-block__item">
                    <p class="sidebar-list-block__text">
                        <img alt="новинка" src="{{asset('images//delivery_car.gif')}}" align="left">
                        <span>Доставляем интернет заказы в регионы России</span>
                    </p>
                </li>
                <li class="sidebar-list-block__item">
                    <p class="sidebar-list-block__text">
                        <img alt="Оплата заказа" src="{{asset('images//pay_digital.gif')}}" align="left">
                        <span>Вы можете оплатить заказ курьеру наличными или через банк.</span>
                    </p>
                </li>
            </ul>
            <div class="sidebar-faq-block">
                <h4 class="sidebar-faq-block__title">Вопросы и ответы:</h4>
                <div class="sidebar-faq-block__row">
                	<div class="sidebar-faq-block__content">
                		 <p>Хочу сделать пол на лагах в новостройке. Фото и план прилагаю.</p>
                		 <p>Прошу смету:</p>
                		 <p><u>На первый этап</u></p>
                		 <p>...</p>
                    </div>
                	<div class="sidebar-faq-block__more">
                		<a href="#">Читать полностью</a>
                	</div>
                </div>
                <div class="sidebar-faq-block__row">
                	<div class="sidebar-faq-block__content">
                	    <p>Добрый день!</p>
                	    <p>Я живу в старом доме. Деревянные полы не ровные. Перепад от стен до центра комнаты до 4 см. Хочу...</p>
                 	</div>
                	<div class="sidebar-faq-block__more">
                		<a href="#">Читать полностью</a>
                	</div>
                </div>
                <div class="sidebar-faq-block__row">
                	<div class="sidebar-faq-block__content">
                		 <p>Здравствуйте! Скрипит паркет. Срочно надо устранить скрип. Циклевать, и т.д. срочно.</p>
                	</div>
                	<div class="sidebar-faq-block__more">
                		<a href="#">Читать полностью</a>
                	</div>
                </div>
                <div class="sidebar-faq-block__apply-question">
                    <a href="/ask/">Задать свой вопрос</a>
                </div>
            </div>
        </div>
    </div>
</div>
