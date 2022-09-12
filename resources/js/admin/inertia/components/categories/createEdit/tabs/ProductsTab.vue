<script lang="ts" setup>
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames} from "@/admin/inertia/modules/routes"

const categoriesStore = useCategoriesStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Активность</th>
                </tr>
                </thead>
                <tbody>
                    <template v-if="categoriesStore.category?.products.length">
                        <tr v-for="categoryProduct in categoriesStore.category.products" :key="`category-product-${categoryProduct.id}`">
                            <td><Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: categoryProduct.id})" target="_blank">{{ categoryProduct.id }}</Link></td>
                            <td><Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: categoryProduct.id})" target="_blank">{{ categoryProduct.name }}</Link></td>
                            <td>{{ categoryProduct.is_active ? 'Да' : 'Нет' }}</td>
                        </tr>
                    </template>
                    <template v-else-if="categoriesStore.category?.id">
                        <tr key="category-product-nothing">
                            <td colspan="3">
                                У этой категории нет продуктов
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>
