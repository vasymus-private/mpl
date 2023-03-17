<script lang="ts" setup>
import NavItem from '@/admin/inertia/components/layout/NavItem.vue'
import {useRoutesStore, RouteTypeEnum, routeNames} from "@/admin/inertia/modules/routes"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {ref} from 'vue'
import {useProfileStore} from "@/admin/inertia/modules/profile"
import CategoriesSub from "@/admin/inertia/components/layout/CategoriesSub.vue"
import {ProductTypeEnum} from "@/admin/inertia/modules/categories/types"


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
                    <CategoriesSub title="Услуги" :categories="categoriesStore.categoriesWorks" :product_type="ProductTypeEnum.works" />

                    <CategoriesSub title="Материалы" :categories="categoriesStore.categoriesMaterials" :product_type="ProductTypeEnum.materials" />
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
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_CONTACT_FORMS_INDEX)"
                            :is-inertia-link="true"
                            title="Элементы"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                    </NavItem>
                    <NavItem
                        id-or-href="reference-gallery-items"
                        :is-inertia-link="false"
                        title="Галерея"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.referenceGalleryItems)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_GALLERY_ITEMS_INDEX)"
                            :is-inertia-link="true"
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
                    :is-active-collapse="isActiveRoute(RouteTypeEnum.highload)"
                    icon-class="adm-icon iblock_menu_icon_types"
                >
                    <NavItem
                        id-or-href="reference-blacklist"
                        :is-inertia-link="false"
                        title="Blacklist"
                        :is-collapse="true"
                        :is-active-collapse="isActiveRoute(RouteTypeEnum.highloadBlacklist)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="routesStore.route(routeNames.ROUTE_ADMIN_BLACKLIST_INDEX)"
                            :is-inertia-link="true"
                            title="Элементы"
                            :is-collapse="false"
                            icon-class="adm-arrow-icon-dot"
                            nav-link-class="sub-level-2"
                        />
                    </NavItem>
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
