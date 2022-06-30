<script lang="ts" setup>
import NavItem from '@/admin/inertia/shared/layout/NavItem.vue'
import {routeNames} from '@/admin/inertia/shared/ziggyRoutes'

</script>

<template>
    <aside id="aside" class="sidebar-left" style="flex-basis: 330px">
        <nav>
            <ul class="nav pt-3">
                <NavItem
                    id-or-href="highload"
                    :is-inertia-link="false"
                    title="Highload-блоки"
                    :is-collapse="true"
                    :is-active-collapse="true"
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
