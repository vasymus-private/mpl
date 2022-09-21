<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import {storeToRefs} from "pinia"
import useRoute from "@/admin/inertia/composables/useRoute"


const ordersStore = useOrdersStore()
const routesStore = useRoutesStore()
const {fullUrl} = storeToRefs(routesStore)

const {} = useRoute(fullUrl)
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="d-flex align-items-center col-sm-5">
                <Link :href="route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_INDEX)" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Список заказов</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>
            </div>

            <div class="col-sm-7 d-flex align-items-center justify-content-end">
                <Link v-if="!ordersStore.isCreatingOrderRoute" :href="route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_CREATE, {'copy_id' : ordersStore.order?.id})" class="btn__copy">Копировать</Link>

                <button type="button" class="btn btn-secondary text-nowrap btn__dropdown">
                    Изменить заказ
                </button>
            </div>
        </div>
    </div>
</template>
