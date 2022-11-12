<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {Inertia} from "@inertiajs/inertia"
import {useToastsStore} from "@/admin/inertia/modules/toasts"


const categoriesStore = useCategoriesStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()

const handleDelete = async () => {
    if (!categoriesStore.category?.id) {
        return
    }

    if (confirm(`Вы уверены, что хотите удалить категорию?`)) {
        let errorsOrVoid = await categoriesStore.deleteBulkCategories([categoriesStore.category.uuid])
        if (!errorsOrVoid) {
            Inertia.visit(
                routesStore.route(
                    routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX
                )
            )
            return
        }

        for (let key in errorsOrVoid) {
            toastsStore.error({
                title: key,
                message: errorsOrVoid[key]
            })
        }
    }
}
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {category_id: categoriesStore.category?.parent_id})" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Разделы</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>
            </div>
            <div v-if="!categoriesStore.isCreatingCategoryRoute" class="col-sm-5 d-flex align-items-center">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_CREATE)" class="btn btn-info mx-1">Добавить раздел</Link>
                <button type="button" @click="handleDelete" class="btn btn-danger mx-1">Удалить раздел</button>
            </div>
        </div>
    </div>
</template>
