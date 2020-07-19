<div class="menu-sidebar">
    <h3 class="menu-sidebar__title">
        <i class="fa fa-bars" aria-hidden="true"></i>
        Паркетные материалы
    </h3>

    <ul class="dropdown-vertical menu-sidebar__list">
    @foreach($categories as $categoryInd => $category)
    <?php /** @var \App\Models\Category $category */ ?>
        <li class="accordion-toggle menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">{{$category->name}}</a>
            @php
                switch ($category->id) {
                    case \App\Models\Category::_TEMP_ID_PARKET : {
                        $menuDividerThreshold = 3;
                        break;
                    }

                }
            @endphp
            <ul>
                @foreach($category->subcategories as $subcategory1Ind => $subcategory1)
                    <?php /** @var \App\Models\Category $subcategory1 */ ?>
                    @if($subcategory1Ind <= $menuDividerThreshold)
                            <li>
                                <p class="dropdown-level_2">
                                    <a class="text-bold" href="/catalog/parquet_glue/water_dispersion_glue/">Водный
                                        клей</a>
                                </p>
                                <p class="dropdown-level_2">
                                    <a class="text-bold" href="/catalog/parquet_glue/glue_on_the_solvents/">Клей на
                                        растворителях</a>
                                </p>
                                <p class="dropdown-level_2">
                                    <a class="text-bold" href="/catalog/parquet_glue/polyurethane_adhesive/">Полиуретановый
                                        клей:</a>
                                </p>
                                <p class="dropdown-level_3 text-small"><a
                                        href="/catalog/parquet_glue/polyurethane_adhesive/two-component_polyurethane_adhesive/">-
                                        Двухкомпонентный клей</a></p>
                                <p class="dropdown-level_3 text-small"><a
                                        href="/catalog/parquet_glue/polyurethane_adhesive/silanovyy_kley/">- Силановый
                                        клей</a></p>
                                <p class="dropdown-level_3 text-small"><a
                                        href="/catalog/parquet_glue/polyurethane_adhesive/kley_na_ms-polimerakh/">- Клей на
                                        MS-полимерах</a></p>
                            </li>
                    @else
                            <li class="last">
                                <p class="dropdown-level_2">
                                    <a class="text-bold" href="/catalog/parquet_glue/ground/">Грунтовка:</a>
                                </p>
                                <p class="dropdown-level_3 text-small"><a
                                        href="/catalog/parquet_glue/ground/vodnaya_gruntovka/">- Водная грунтовка</a></p>
                                <p class="dropdown-level_3 text-small"><a
                                        href="/catalog/parquet_glue/ground/poliuretanovaya_gruntovka/">- Полиуретановая
                                        грунтовка</a></p>
                                <p class="dropdown-level_3 text-small"><a
                                        href="/catalog/parquet_glue/ground/epoksidnaya_gruntovka/">- Эпоксидная
                                        грунтовка</a></p>
                            </li>
                    @endif
                @endforeach


            </ul>
        </li>
    @endforeach
    </ul>

    <ul class="dropdown-vertical menu-sidebar__list">
        <li class="accordion-toggle menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">ПАРКЕТ</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parket/parquet_sht/">Штучный паркет</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parket/massive_board/">Массивная доска</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parket/laminated_flooring/">Ламинат</a>
                    </p>
                </li>
                <li class="last">
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parket/ingenernaja_doska/">Инженерная доска</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parket/modular_flooring/">Модульный паркет</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parket/industrialnyy_parket/">Индустриальный
                            паркет</a>
                    </p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">ПАРКЕТНЫЙ КЛЕЙ</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parquet_glue/water_dispersion_glue/">Водный
                            клей</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parquet_glue/glue_on_the_solvents/">Клей на
                            растворителях</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parquet_glue/polyurethane_adhesive/">Полиуретановый
                            клей:</a>
                    </p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parquet_glue/polyurethane_adhesive/two-component_polyurethane_adhesive/">-
                            Двухкомпонентный клей</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parquet_glue/polyurethane_adhesive/silanovyy_kley/">- Силановый
                            клей</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parquet_glue/polyurethane_adhesive/kley_na_ms-polimerakh/">- Клей на
                            MS-полимерах</a></p>
                </li>
                <li class="last">
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parquet_glue/ground/">Грунтовка:</a>
                    </p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parquet_glue/ground/vodnaya_gruntovka/">- Водная грунтовка</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parquet_glue/ground/poliuretanovaya_gruntovka/">- Полиуретановая
                            грунтовка</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parquet_glue/ground/epoksidnaya_gruntovka/">- Эпоксидная
                            грунтовка</a></p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">ПАРКЕТНЫЙ ЛАК</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnyy_lak/Laquer_water/">Лак водный:</a>
                    </p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parketnyy_lak/Laquer_water/lacquer-acrylic/">- Лак акриловый</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parketnyy_lak/Laquer_water/lak_uretan-akrilovyy/">- Лак
                            уретан-акриловый</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parketnyy_lak/Laquer_water/lacquer_polyurethane/">- Лак
                            полиуретановый</a></p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnyy_lak/acid_lac/">Лак кислотный</a>
                    </p>
                </li>
                <li class="last">
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnyy_lak/laquer_urethane-alkyd/">Лак
                            уретан-алкидный</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnyy_lak/primer/">Лак-грунтовка:</a>
                    </p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parketnyy_lak/primer/gruntovka_water/">- Грунтовка водная</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parketnyy_lak/primer/primer_solvents/">- Грунтовка на
                            растворителях</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/parketnyy_lak/primer/gruntovka_maslyannaya/">- Грунтовка
                            маслянная</a></p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnyy_lak/toning/">Тонирующие составы</a>
                    </p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">ПАРКЕТНОЕ МАСЛО</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnoe_maslo/maslo_1-komponentnoe/">Масло
                            1-компонентное</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnoe_maslo/maslo_2-komponentnoe/">Масло
                            2-компонентное</a>
                    </p>
                </li>
                <li class="last">
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnoe_maslo/maslo_s_tverdym_voskom/">Масло с
                            твердым воском</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/parketnoe_maslo/tsvetnoe_maslo/">Цветное
                            масло</a>
                    </p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">ШПАКЛЕВКА</a>
            <ul class="small-submenu">
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/shpaklevka/shpaklevka_vodnaya/">Шпаклевка
                            водная</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/shpaklevka/shpaklevka_na_rastvoritelyakh/">Шпаклевка
                            на растворителях</a>
                    </p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">СРЕДСТВА ПО УХОДУ</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_parketnym_lakom/">Уход
                            за лаком</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_parketnym_maslom/">Уход
                            за маслом</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_terrasnoy_doskoy/">Уход
                            за террасной доской</a>
                    </p>
                </li>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_kamennym_polom/">Уход
                            за каменным полом</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_kovrami/">Уход за
                            коврами</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold"
                           href="/catalog/sredstva_po_ukhodu/ukhod_za_sportivnymi_elastichnymi_pokrytiyami_pvc_i_reziny/">Уход
                            за ламинатом, линолеумом, винилом</a>
                    </p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">ОСНОВАНИЕ ПОЛА</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_parketnym_lakom/">Уход
                            за лаком</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_parketnym_maslom/">Уход
                            за маслом</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_terrasnoy_doskoy/">Уход
                            за террасной доской</a>
                    </p>
                </li>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_kamennym_polom/">Уход
                            за каменным полом</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/sredstva_po_ukhodu/ukhod_za_kovrami/">Уход за
                            коврами</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold"
                           href="/catalog/sredstva_po_ukhodu/ukhod_za_sportivnymi_elastichnymi_pokrytiyami_pvc_i_reziny/">Уход
                            за ламинатом, линолеумом, винилом</a>
                    </p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">ОБОРУДОВАНИЕ</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/oborudovanie/tsiklevochnye_mashiny/">Циклевочные
                            машины:</a>
                    </p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/oborudovanie/tsiklevochnye_mashiny/shlifovalnye_mashiny/">-
                            Шлифовальные машины</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/oborudovanie/tsiklevochnye_mashiny/zapchasti_shlifmashin/">- Запчасти
                            шлифмашин</a></p>
                </li>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/oborudovanie/abrasives/">Абразив</a>
                    </p>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/oborudovanie/oborudovanie_i_instrument/">Инструмент</a>
                    </p>
                </li>
            </ul>
        </li>
        <li class="menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">Сопутствующие товары</a>
            <ul>
                <li>
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/skirting_thresholds_molded_materials/plintus/">Плинтус:</a>
                    </p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/skirting_thresholds_molded_materials/plintus/metal_plinthus/">-
                            Металлический плинтус</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/skirting_thresholds_molded_materials/plintus/plastic_plintus/">-
                            Пластиковый плинтус</a></p>
                    <p class="dropdown-level_3 text-small"><a
                            href="/catalog/skirting_thresholds_molded_materials/plintus/derevyannyy_plintus/">-
                            Деревянный плинтус</a></p>
                </li>
                <li class="last">
                    <p class="dropdown-level_2">
                        <a class="text-bold" href="/catalog/skirting_thresholds_molded_materials/porozhki/">Порожки</a>
                    </p>
                </li>
            </ul>
        </li>
    </ul>
</div>
