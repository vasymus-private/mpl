<script lang="ts" setup>
import {CategoriesTreeItem, ProductTypeEnum} from "@/admin/inertia/modules/categories/types"
import NavItem from '@/admin/inertia/components/layout/NavItem.vue'
import {RouteTypeEnum, useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"


const props = defineProps<{
    categories: Array<CategoriesTreeItem>
    title: string
    product_type: ProductTypeEnum
}>()

const routesStore = useRoutesStore()

const isActiveRoute = (type: RouteTypeEnum, id: number | string = null, product_type: ProductTypeEnum|null = null): boolean => {
    return routesStore.isActiveRoute(type, id, product_type)
}
</script>

<template>
    <NavItem
        id-or-href="categories-sub"
        :title="props.title"
        :is-inertia-link="false"
        :is-collapse="true"
        :is-active-collapse="isActiveRoute(RouteTypeEnum.categoriesSub, null)"
        icon-class="adm-icon iblock_menu_icon_iblocks"
        nav-link-class="sub-level-1"
        :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {product_type: props.product_type})"
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
            v-for="category in props.categories"
            :id-or-href="`categories-${category.id}`"
            :title="category.name"
            :is-inertia-link="false"
            :is-collapse="true"
            :is-active-collapse="isActiveRoute(RouteTypeEnum.categories, category.id)"
            icon-class="adm-icon iblock_menu_icon_sections"
            nav-link-class="sub-level-2"
            :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {product_type: props.product_type, category_id: category.id})"
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
                :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {product_type: props.product_type, category_id: subcategory1.id})"
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
                    :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {product_type: props.product_type, category_id: subcategory2.id})"
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
                        :nav-link-text-href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {product_type: props.product_type, category_id: subcategory3.id})"
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
</template>
