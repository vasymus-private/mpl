<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import {useCreateEditOrderFormStore} from "@/admin/inertia/modules/forms/createEditOrder"


const ordersStore = useOrdersStore()
const routesStore = useRoutesStore()
const createEditOrderFormStore = useCreateEditOrderFormStore()
const toggleMode = () => {
    if (createEditOrderFormStore.couldBeChangedByAdmin) {
        createEditOrderFormStore.toggleEditMode()
    }
}
const handleDelete = () => {
    if (confirm(`Вы уверены, что хотите удалить заказ №${ordersStore.order?.id}?`)) {
        // todo
        console.log('--- deleting')
    }
}
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="d-flex align-items-center col-sm-5">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_INDEX)" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Список заказов</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>
            </div>

            <div class="col-sm-7 d-flex align-items-center justify-content-end">
                <span
                    v-if="!createEditOrderFormStore.couldBeChangedByAdmin && !createEditOrderFormStore.isEditMode"
                    class="btn btn-secondary text-nowrap btn__dropdown"
                >
                    Изменение заблокировано
                </span>
                <button
                    v-else
                    @click="toggleMode"
                    type="button"
                    class="btn btn-secondary text-nowrap btn__dropdown"
                >
                    {{ createEditOrderFormStore.isEditMode ? 'Подробности заказа' : 'Изменить заказ' }}
                </button>

                <Link v-if="!ordersStore.isCreatingOrderRoute" :href="routesStore.route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_CREATE)" class="btn btn-secondary text-nowrap btn__dropdown">Создать</Link>

                <Link v-if="!ordersStore.isCreatingOrderRoute" :href="routesStore.route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_CREATE, {'copy_id' : ordersStore.order?.id})" class="btn__copy">Копировать</Link>

                <button v-if="!ordersStore.isCreatingOrderRoute" type="button" @click="handleDelete" class="btn btn-secondary text-nowrap btn__dropdown">Удалить</button>
            </div>
        </div>
    </div>
</template>
