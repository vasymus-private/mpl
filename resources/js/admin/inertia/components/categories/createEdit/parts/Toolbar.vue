<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames} from "@/admin/inertia/modules/routes"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"


const categoriesStore = useCategoriesStore()
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <Link :href="route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {category_id: categoriesStore.category?.parent_id})" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Разделы</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>
            </div>
            <div class="col-sm-5 d-flex align-items-center">
                <Link :href="route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_CREATE)" class="btn btn-info mx-1">Добавить раздел</Link>
                <button type="button" @click="categoriesStore.deleteCategory()" class="btn btn-danger mx-1">Удалить раздел</button>
            </div>
        </div>
    </div>
</template>
