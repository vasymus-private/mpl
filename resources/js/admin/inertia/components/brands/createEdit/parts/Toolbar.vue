<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {Inertia} from "@inertiajs/inertia"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {useBrandsStore} from "@/admin/inertia/modules/brands"


const brandsStore = useBrandsStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()

const handleDelete = async () => {
    if (!brandsStore.brand?.id) {
        return
    }

    if (confirm(`Вы уверены, что хотите удалить производителя?`)) {
        let errorsOrVoid = await brandsStore.deleteBulkBrands([brandsStore.brand.id])
        if (!errorsOrVoid) {
            Inertia.visit(
                routesStore.route(
                    routeNames.ROUTE_ADMIN_BRANDS_TEMP_INDEX
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
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_BRANDS_TEMP_INDEX)" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Производители</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>
            </div>
            <div v-if="!brandsStore.isCreatingBrandRoute" class="col-sm-5 d-flex align-items-center">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_BRANDS_TEMP_CREATE)" class="btn btn-info mx-1">Добавить</Link>
                <button type="button" @click="handleDelete" class="btn btn-danger mx-1">Удалить</button>
            </div>
        </div>
    </div>
</template>
