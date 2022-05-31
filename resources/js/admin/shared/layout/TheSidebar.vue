<template>
    <aside id="aside" class="sidebar-left" style="flex-basis: 330px">
        <nav class="js-admin-sidbar">
            <ul is="b-nav" class="pt-3">
                <li class="nav-item">
                    <a href="#categories" v-b-toggle.categories class="nav-link">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_types"></span>
                        <span class="nav-link-text">Каталог товаров</span>
                    </a>
                    <ul is="b-collapse" tag="ul" id="categories" class="nav">
                        <li class="nav-item">
                            <a href="#categories-sub" v-b-toggle.categories-sub class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="d-flex align-items-center justify-content-center">
                                    <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                    <span class="nav-link-text">Каталог товаров</span>
                                </span>
                            </a>
                            <ul is="b-collapse" tag="ul" id="categories-sub" class="nav">
                                <li class="nav-item">
                                    <a :href="route('admin.products.index')" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Товары</span>
                                    </a>
                                </li>
                                <li v-for="category in categories" class="nav-item">
                                    <a :href="`#categories-${category.id}`" v-b-toggle="`categories-${category.id}`" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon"></span>
                                        <span class="d-flex align-items-center justify-content-center">
                                            <span class="adm-icon iblock_menu_icon_sections"></span>
                                            <span class="nav-link-text">{{category.name}}</span>
                                        </span>
                                    </a>
                                    <ul is="b-collapse" tag="ul" :id="`categories-${category.id}`" class="nav">
                                        <li class="nav-item">
                                            <a :href="route('admin.products.index', {category_id : category.id})" class="nav-link sub-level-3">
                                                <span class="adm-arrow-icon-dot"></span>
                                                <span class="nav-link-text">Товары</span>
                                            </a>
                                        </li>
                                        <li v-for="subcategory1 in category.subcategories" class="nav-item">
                                            <a
                                                :href="`#categories-${subcategory1.id}`"
                                                v-b-toggle="`categories-${subcategory1.id}`"
                                                class="nav-link sub-level-3"
                                            >
                                                <span class="adm-arrow-icon"></span>
                                                <span class="d-flex align-items-center justify-content-center">
                                                    <span class="adm-icon iblock_menu_icon_sections"></span>
                                                    <span class="nav-link-text">{{subcategory1.name}}</span>
                                                </span>
                                            </a>
                                            <ul is="b-collapse" tag="ul" :id="`categories-${subcategory1.id}`" class="nav">
                                                <li class="nav-item">
                                                    <a :href="route('admin.products.index', {category_id: subcategory1.id})" class="nav-link sub-level-4">
                                                        <span class="adm-arrow-icon-dot"></span>
                                                        <span class="nav-link-text">Товары</span>
                                                    </a>
                                                </li>
                                                <li v-for="subcategory2 in subcategory1.subcategories" class="nav-item">
                                                    <a
                                                        :href="`#categories-${subcategory2.id}`"
                                                        v-b-toggle="`categories-${subcategory2.id}`"
                                                        class="nav-link sub-level-4"
                                                    >
                                                        <span class="adm-arrow-icon"></span>
                                                        <span class="d-flex align-items-center justify-content-center">
                                                            <span class="adm-icon iblock_menu_icon_sections"></span>
                                                            <span class="nav-link-text">{{subcategory2.name}}</span>
                                                        </span>
                                                    </a>
                                                    <ul is="b-collapse" tag="ul" :id="`categories-${subcategory2.id}`" class="nav">
                                                        <li class="nav-item">
                                                            <a :href="route('admin.products.index', {category_id: subcategory2.id})" class="nav-link sub-level-5">
                                                                <span class="adm-arrow-icon-dot"></span>
                                                                <span class="nav-link-text">Товары</span>
                                                            </a>
                                                        </li>
                                                        <li v-for="subcategory3 in subcategory2.subcategories" class="nav-item">
                                                            <a
                                                                :href="`#categories-${subcategory3.id}`"
                                                                v-b-toggle="`categories-${subcategory3.id}`"
                                                                class="nav-link sub-level-5"
                                                            >
                                                                <span class="adm-arrow-icon"></span>
                                                                <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                <span class="nav-link-text">{{subcategory3.name}}</span>
                                                            </a>
                                                            <ul is="b-collapse" tag="ul" :id="`categories-${subcategory3.id}`" class="nav">
                                                                <li class="nav-item">
                                                                    <a :href="route('admin.products.index', {category_id: subcategory3.id})" class="nav-link sub-level-6">
                                                                        <span class="adm-arrow-icon-dot"></span>
                                                                        <span class="nav-link-text">Товары</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#reference" v-b-toggle.reference class="nav-link">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_types"></span>
                        <span class="nav-link-text">Справочники</span>
                    </a>
                    <ul is="b-collapse" tag="ul" id="reference" class="nav">
                        <li class="nav-item">
                            <a href="#reference-1" v-b-toggle.reference-1 class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Производители</span>
                            </a>
                            <ul is="b-collapse" tag="ul" id="reference-1" class="nav">
                                <li class="nav-item">
                                    <a :href="route('admin.brands.index')" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-2" v-b-toggle.reference-2 class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Статьи</span>
                            </a>
                            <ul is="b-collapse" tag="ul" id="reference-2" class="nav">
                                <li class="nav-item">
                                    <Link :href="route('admin.articles.index')" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-3" v-b-toggle.reference-3 class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Услуги</span>
                            </a>
                            <ul is="b-collapse" tag="ul" id="reference-3" class="nav">
                                <li class="nav-item">
                                    <Link :href="route('admin.services.index')" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-4" v-b-toggle.reference-4 class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Отзывы о товарах и услугах</span>
                            </a>
                            <ul is="b-collapse" tag="ul" id="reference-4" class="nav">
                                <li class="nav-item">
                                    <a href="#" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-5" v-b-toggle.reference-5 class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Вопрос-ответ</span>
                            </a>
                            <ul is="b-collapse" tag="ul" id="reference-5" class="nav">
                                <li class="nav-item">
                                    <a href="#" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-6" v-b-toggle.reference-6 class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Контактные формы</span>
                            </a>
                            <ul is="b-collapse" tag="ul" id="reference-6" class="nav">
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
                    <a href="#highload" v-b-toggle.highload class="nav-link collapsed">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon highloadblock_menu_icon"></span>
                        <span class="nav-link-text">Highload-блоки</span>
                    </a>
                    <ul is="b-collapse" tag="ul" id="highload" class="nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link sub-level-1">
                                <span class="adm-arrow-icon-dot"></span>
                                <span class="nav-link-text">Blacklist</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a :href="route('admin.orders.index')" class="nav-link">
                        <span style="width: 20px;"></span>
                        <span class="adm-icon iblock_menu_icon_types"></span>
                        <span class="nav-link-text">Заказы</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a :href="route('admin.export-products.index')" class="nav-link">
                        <span style="width: 20px;"></span>
                        <span class="adm-icon iblock_menu_icon_types"></span>
                        <span class="nav-link-text">Экспорт</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
    components: {
        Link
    },
    computed: {
        categories() {
            return this.$page.props.categoriesTree
        }
    },
    methods: {
        isActive() {

        }
    }
}
</script>
