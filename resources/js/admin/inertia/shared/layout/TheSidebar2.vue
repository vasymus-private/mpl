<script lang="ts" setup>
import NavItem from '@/admin/inertia/shared/layout/NavItem.vue'
import {useRoutesStore, RouteTypeEnum, routeNames} from "@/admin/inertia/modules/routes"


const routesStore = useRoutesStore()
</script>

<template>
    <aside id="aside" class="sidebar-left" style="flex-basis: 330px">
        <nav>
            <ul class="nav pt-3">
                <NavItem
                    id-or-href="reference"
                    :is-inertia-link="false"
                    title="Справочники"
                    :is-collapse="true"
                    :is-active-collapse="routesStore.isActiveRoute(RouteTypeEnum.reference)"
                    icon-class="adm-icon iblock_menu_icon_types"
                >
                    <NavItem
                        id-or-href="reference-brands"
                        :is-inertia-link="false"
                        title="Производители"
                        :is-collapse="true"
                        :is-active-collapse="routesStore.isActiveRoute(RouteTypeEnum.referenceBrands)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="route(routeNames.ROUTE_ADMIN_BRANDS_INDEX)"
                            :is-inertia-link="false"
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
                        :is-active-collapse="routesStore.isActiveRoute(RouteTypeEnum.referenceArticles)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="route(routeNames.ROUTE_ADMIN_ARTICLES_INDEX)"
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
                        :is-active-collapse="routesStore.isActiveRoute(RouteTypeEnum.referenceServices)"
                        icon-class="adm-icon iblock_menu_icon_iblocks"
                        nav-link-class="sub-level-1"
                    >
                        <NavItem
                            :id-or-href="route(routeNames.ROUTE_ADMIN_SERVICES_INDEX)"
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
                        :is-active-collapse="routesStore.isActiveRoute(RouteTypeEnum.referenceFaq)"
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
                    <NavItem
                        id-or-href="reference-contacts"
                        :is-inertia-link="false"
                        title="Контактные формы"
                        :is-collapse="true"
                        :is-active-collapse="routesStore.isActiveRoute(RouteTypeEnum.referenceContacts)"
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
                    :id-or-href="route(routeNames.ROUTE_ADMIN_ORDERS_INDEX)"
                    :is-inertia-link="false"
                    title="Заказы"
                    :is-collapse="false"
                    icon-class="adm-icon iblock_menu_icon_types"
                    :is-arrow-space="true"
                />
                <NavItem
                    :id-or-href="route(routeNames.ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX)"
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
