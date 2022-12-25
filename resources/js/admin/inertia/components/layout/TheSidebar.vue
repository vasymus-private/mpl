<script lang="ts" setup>
import NavItem from '@/admin/inertia/components/layout/NavItem.vue'
import {useRoutesStore, RouteTypeEnum, routeNames} from "@/admin/inertia/modules/routes"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {ref} from 'vue'
import {useProfileStore} from "@/admin/inertia/modules/profile"


const routesStore = useRoutesStore()
const categoriesStore = useCategoriesStore()
const profileStore = useProfileStore()

const aside = ref(null)
defineExpose({
    element: aside,
})

const isActiveRoute = (type: RouteTypeEnum, id: number | string = null): boolean => {
    return routesStore.isActiveRoute(type, id)
}
</script>

<template>
    <aside ref="aside" id="aside" class="sidebar-left" :style="{flexBasis: `${profileStore.adminSidebarFlexBasis}px`}">
        <nav>
            <ul class="nav pt-3">
                <NavItem
                    id-or-href="categories"
                    :is-inertia-link="false"
                    title="Каталог товаров"
                    :is-collapse="true"
                    :is-active-collapse="isActiveRoute(RouteTypeEnum.categories)"
                    icon-class="adm-icon iblock_menu_icon_types"
                >
                    <NavItem
                        id-or-href="categories-sub"
                        title="Каталог товаров"
                        :is-inertia-link="false"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.categoriesSub)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                        :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX)"
                    >
                        <NavItem
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX)"
                            title="Товары"
                            :is-inertia-link="true"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                        <NavItem
                            v-for="category in categoriesStore.categories"
                            :id-or-href="`categories-${category.id}`"
                            :title="category.name"
                            :is-inertia-link="false"
                            :is-collapse="true"
                            :is-active-collapse="isActiveRoute(RouteTypeEnum.categories, category.id)"
                            icon-class="adm-icon iblock_menu_icon_sections"
                            nav-link-class="sub-level-2"
                            :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {category_id: category.id})"
                        >
                            <NavItem
                                :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id : category.id})"
                                title="Товары"
                                :is-inertia-link="true"
                                :is-collapse="false"
                                icon-class="adm-arrow-icon-dot"
                                nav-link-class="sub-level-3"
                            />
                            <NavItem
                                v-for="subcategory1 in category.subcategories"
                                :id-or-href="`categories-${subcategory1.id}`"
                                :title="subcategory1.name"
                                :is-inertia-link="false"
                                :is-collapse="true"
                                :is-active-collapse="isActiveRoute(RouteTypeEnum.categories, subcategory1.id)"
                                icon-class="adm-icon iblock_menu_icon_sections"
                                nav-link-class="sub-level-3"
                                :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {category_id: subcategory1.id})"
                            >
                                <NavItem
                                    :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id : subcategory1.id})"
                                    title="Товары"
                                    :is-inertia-link="true"
                                    :is-collapse="false"
                                    icon-class="adm-arrow-icon-dot"
                                    nav-link-class="sub-level-4"
                                />
                                <NavItem
                                    v-for="subcategory2 in subcategory1.subcategories"
                                    :id-or-href="`categories-${subcategory2.id}`"
                                    :title="subcategory2.name"
                                    :is-inertia-link="false"
                                    :is-collapse="true"
                                    :is-active-collapse="isActiveRoute(RouteTypeEnum.categories, subcategory2.id)"
                                    icon-class="adm-icon iblock_menu_icon_sections"
                                    nav-link-class="sub-level-4"
                                    :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {category_id: subcategory2.id})"
                                >
                                    <NavItem
                                        :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id : subcategory2.id})"
                                        title="Товары"
                                        :is-inertia-link="true"
                                        :is-collapse="false"
                                        icon-class="adm-arrow-icon-dot"
                                        nav-link-class="sub-level-5"
                                    />
                                    <NavItem
                                        v-for="subcategory3 in subcategory2.subcategories"
                                        :id-or-href="`categories-${subcategory3.id}`"
                                        :title="subcategory3.name"
                                        :is-inertia-link="false"
                                        :is-collapse="true"
                                        :is-active-collapse="isActiveRoute(RouteTypeEnum.categories, subcategory3.id)"
                                        icon-class="adm-icon iblock_menu_icon_sections"
                                        nav-link-class="sub-level-5"
                                        :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {category_id: subcategory3.id})"
                                    >
                                        <NavItem
                                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id : subcategory3.id})"
                                            title="Товары"
                                            :is-inertia-link="true"
                                            :is-collapse="false"
                                            icon-class="adm-arrow-icon-dot"
                                            nav-link-class="sub-level-6"
                                        />
                                    </NavItem>
                                </NavItem>
                            </NavItem>
                        </NavItem>
                    </NavItem>
                </NavItem>
                <NavItem
                    id-or-href="reference"
                    :is-inertia-link="false"
                    title="Справочники"
                    :is-collapse="true"
                    :is-active-collapse="isActiveRoute(RouteTypeEnum.reference)"
                    icon-class="adm-icon iblock_menu_icon_types"
                >
                    <NavItem
                        id-or-href="reference-brands"
                        :is-inertia-link="false"
                        title="Производители"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.referenceBrands)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_BRANDS_TEMP_INDEX)"
                            :is-inertia-link="true"
                            title="Элементы"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                    </NavItem>
                    <NavItem
                        id-or-href="reference-articles"
                        :is-inertia-link="false"
                        title="Статьи"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.referenceArticles)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_ARTICLES_INDEX)"
                            :is-inertia-link="true"
                            title="Элементы"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                    </NavItem>
                    <NavItem
                        id-or-href="reference-services"
                        :is-inertia-link="false"
                        title="Услуги"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.referenceServices)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_SERVICES_INDEX)"
                            :is-inertia-link="true"
                            title="Элементы"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                    </NavItem>
                    <NavItem
                        id-or-href="reference-faq"
                        :is-inertia-link="false"
                        title="Вопрос-ответ"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.referenceFaq)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_FAQ_INDEX)"
                            :is-inertia-link="true"
                            title="Элементы"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                    </NavItem>
                    <NavItem
                        id-or-href="reference-contacts"
                        :is-inertia-link="false"
                        title="Контактные формы"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.referenceContacts)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            id-or-href="#"
                            :is-inertia-link="false"
                            title="Элементы"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                    </NavItem>
                </NavItem>
                <NavItem
                    id-or-href="highload"
                    :is-inertia-link="false"
                    title="Highload-блоки"
                    :is-collapse="true"
                    :is-active-collapse="false"
                    icon-class="adm-icon iblock_menu_icon_types"
                >
                    <NavItem
                        title="Blacklist"
                        id-or-href="#"
                        :is-inertia-link="false"
                        :is-collapse="false"
                        icon-class="adm-arrow-icon-dot"
                        nav-link-class="sub-level-1"
                    />
                </NavItem>
                <NavItem
                    :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_INDEX)"
                    :is-inertia-link="true"
                    title="Заказы"
                    :is-collapse="false"
                    icon-class="adm-icon iblock_menu_icon_types"
                    :is-arrow-space="true"
                />
                <NavItem
                    :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX)"
                    :is-inertia-link="false"
                    title="Экспорт"
                    :is-collapse="false"
                    icon-class="adm-icon iblock_menu_icon_types"
                    :is-arrow-space="true"
                />
            </ul>
        </nav>
    </aside>
</template>
