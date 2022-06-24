<template>
    <aside id="aside" class="sidebar-left" style="flex-basis: 330px">
        <nav>
            <ul is="b-nav" class="pt-3">
                <li class="nav-item">
                    <a href="#categories" v-b-toggle.categories class="nav-link">
                        <span class="adm-arrow-icon"></span>
                        <span class="adm-icon iblock_menu_icon_types"></span>
                        <span class="nav-link-text">Каталог товаров</span>
                    </a>
                    <ul is="b-collapse" :visible="isActive(routeTypes.categories)" tag="ul" id="categories" class="nav">
                        <li class="nav-item">
                            <a href="#categories-sub" v-b-toggle.categories-sub class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="d-flex align-items-center justify-content-center">
                                    <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                    <span class="nav-link-text">Каталог товаров</span>
                                </span>
                            </a>
                            <ul is="b-collapse" :visible="isActive(routeTypes.categoriesSub)" tag="ul" id="categories-sub" class="nav">
                                <li class="nav-item">
                                    <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX)" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Товары</span>
                                    </Link>
                                </li>
                                <li v-for="category in categories" class="nav-item">
                                    <a :href="`#categories-${category.id}`" v-b-toggle="`categories-${category.id}`" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon"></span>
                                        <span class="d-flex align-items-center justify-content-center">
                                            <span class="adm-icon iblock_menu_icon_sections"></span>
                                            <span class="nav-link-text">{{category.name}}</span>
                                        </span>
                                    </a>
                                    <ul is="b-collapse" :visible="isActive(routeTypes.categories, category.id)" tag="ul" :id="`categories-${category.id}`" class="nav">
                                        <li class="nav-item">
                                            <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id : category.id})" class="nav-link sub-level-3">
                                                <span class="adm-arrow-icon-dot"></span>
                                                <span class="nav-link-text">Товары</span>
                                            </Link>
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
                                            <ul is="b-collapse" :visible="isActive(routeTypes.categories, subcategory1.id)" tag="ul" :id="`categories-${subcategory1.id}`" class="nav">
                                                <li class="nav-item">
                                                    <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id: subcategory1.id})" class="nav-link sub-level-4">
                                                        <span class="adm-arrow-icon-dot"></span>
                                                        <span class="nav-link-text">Товары</span>
                                                    </Link>
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
                                                    <ul is="b-collapse" :visible="isActive(routeTypes.categories, subcategory2.id)" tag="ul" :id="`categories-${subcategory2.id}`" class="nav">
                                                        <li class="nav-item">
                                                            <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id: subcategory2.id})" class="nav-link sub-level-5">
                                                                <span class="adm-arrow-icon-dot"></span>
                                                                <span class="nav-link-text">Товары</span>
                                                            </Link>
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
                                                            <ul is="b-collapse" :visible="isActive(routeTypes.categories, subcategory3.id)" tag="ul" :id="`categories-${subcategory3.id}`" class="nav">
                                                                <li class="nav-item">
                                                                    <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id: subcategory3.id})" class="nav-link sub-level-6">
                                                                        <span class="adm-arrow-icon-dot"></span>
                                                                        <span class="nav-link-text">Товары</span>
                                                                    </Link>
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
                    <ul is="b-collapse" :visible="isActive(routeTypes.reference)" tag="ul" id="reference" class="nav">
                        <li class="nav-item">
                            <a href="#reference-brands" v-b-toggle.reference-brands class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Производители</span>
                            </a>
                            <ul is="b-collapse" :visible="isActive(routeTypes.referenceBrands)" tag="ul" id="reference-brands" class="nav">
                                <li class="nav-item">
                                    <a :href="route(routeNames.ROUTE_ADMIN_BRANDS_INDEX)" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-articles" v-b-toggle.reference-articles class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Статьи</span>
                            </a>
                            <ul is="b-collapse" :visible="isActive(routeTypes.referenceArticles)" tag="ul" id="reference-articles" class="nav">
                                <li class="nav-item">
                                    <Link :href="route(routeNames.ROUTE_ADMIN_ARTICLES_INDEX)" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-services" v-b-toggle.reference-services class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Услуги</span>
                            </a>
                            <ul is="b-collapse" :visible="isActive(routeTypes.referenceServices)" tag="ul" id="reference-services" class="nav">
                                <li class="nav-item">
                                    <Link :href="route(routeNames.ROUTE_ADMIN_SERVICES_INDEX)" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-faq" v-b-toggle.reference-faq class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Вопрос-ответ</span>
                            </a>
                            <ul is="b-collapse" :visible="isActive(routeTypes.referenceFaq)" tag="ul" id="reference-faq" class="nav">
                                <li class="nav-item">
                                    <a href="#" class="nav-link sub-level-2">
                                        <span class="adm-arrow-icon-dot"></span>
                                        <span class="nav-link-text">Элементы</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#reference-contacts" v-b-toggle.reference-contacts class="nav-link sub-level-1">
                                <span class="adm-arrow-icon"></span>
                                <span class="adm-icon iblock_menu_icon_iblocks"></span>
                                <span class="nav-link-text">Контактные формы</span>
                            </a>
                            <ul is="b-collapse" :visible="isActive(routeTypes.referenceContacts)" tag="ul" id="reference-contacts" class="nav">
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
                    <a :href="route(routeNames.ROUTE_ADMIN_ORDERS_INDEX)" class="nav-link">
                        <span style="width: 20px;"></span>
                        <span class="adm-icon iblock_menu_icon_types"></span>
                        <span class="nav-link-text">Заказы</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a :href="route(routeNames.ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX)" class="nav-link">
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
import { Link } from '@inertiajs/inertia-vue3'
import routeNames from "@/admin/mixins/routeNames";

export default {
    components: {
        Link
    },
    mixins: [
        routeNames,
    ],
    computed: {
        categories() {
            return this.$page.props.categoriesTree
        }
    },
    created() {
        window._route = this.route
        console.log('---', this.categories)
        window._test = this.getCategoryAndSubtreeIds
    },
    data() {
        return {
            cache: new Map(),
            routeTypes: {
                categoriesSub : 'categories-sub',
                categories: 'categories',
                reference: 'reference',
                referenceBrands: 'reference-brands',
                referenceArticles: 'reference-articles',
                referenceServices: 'reference-services',
                referenceFaq: 'reference-faq',
                referenceContacts: 'reference-contacts',
            },
        }
    },
    methods: {
        isActive(type, id = null) {
            switch (type) {
                case this.routeTypes.categoriesSub:
                case this.routeTypes.categories: {
                    if (!this.route().current('admin.products.*') && !this.route().current('admin.categories.*')) {
                        return false
                    }

                    if (id === null) {
                        return true;
                    }

                    let categoryAndSubtreeIds = this.getCategoryAndSubtreeIds(id)

                    if (!categoryAndSubtreeIds) {
                        return false
                    }

                    let categoryIdParam = +this.route().params.category_id

                    return categoryAndSubtreeIds.includes(categoryIdParam)
                }
                case this.routeTypes.reference: {
                    return this.route().current('admin.brands.*') ||
                        this.route().current('admin.articles.*') ||
                        this.route().current('admin.services.*') ||
                        this.route().current('admin.faq.*') ||
                        this.route().current('admin.contacts.*')
                }
                case this.routeTypes.referenceBrands: {
                    return this.route().current('admin.brands.*')
                }
                case this.routeTypes.referenceArticles: {
                    return this.route().current('admin.articles.*')
                }
                case this.routeTypes.referenceServices: {
                    return this.route().current('admin.services.*')
                }
                case this.routeTypes.referenceFaq: {
                    return this.route().current('admin.faq.*')
                }
                case this.routeTypes.referenceContacts: {
                    return this.route().current('admin.contacts.*')
                }
                default: {
                    return false
                }
            }
        },
        getCategoryAndSubtreeIds(id) {
            if (this.cache.get(id)) {
                return this.cache.get(id)
            }

            let getCategoryAndSubcategoryCb = (categories, _id) => {
                for (let i = 0; i < categories.length; i++) {
                    if (categories[i].id === _id) {
                        return categories[i]
                    }

                    let res = getCategoryAndSubcategoryCb(categories[i].subcategories, _id)
                    if (res) {
                        return res
                    }
                }

                return null
            }

            let categoryAndSubcategories = getCategoryAndSubcategoryCb(this.categories, id)

            if (!categoryAndSubcategories) {
                this.cache.set(id, null)
                return this.cache.get(id)
            }

            let getIdsCb = (acc, category) => {
                acc = [...acc, category.id]
                for (let i = 0; i < category.subcategories.length; i++) {
                    acc = getIdsCb(acc, category.subcategories[i])
                }
                return acc
            }

            this.cache.set(
                id,
                getIdsCb([], categoryAndSubcategories)
            )

            return this.cache.get(id)
        }
    }
}
</script>
