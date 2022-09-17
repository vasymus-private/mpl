<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import RowInput from '@/admin/inertia/components/forms/native/RowInput.vue'
import RowSelect from '@/admin/inertia/components/forms/native/RowSelect.vue'
import {storeToRefs} from "pinia"
import {useAuthStore} from "@/admin/inertia/modules/auth"
import {withEmptyOption} from "@/admin/inertia/modules/common"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import {Link} from "@inertiajs/inertia-vue3"
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"


const ordersStore = useOrdersStore()
const routesStore = useRoutesStore()
const authStore = useAuthStore()
const modalsStore = useModalsStore()

const {fullUrl} = storeToRefs(routesStore)
const {adminOptions} = storeToRefs(authStore)
const { dateFrom, dateTo, orderId, email, name, admin, handleOrdersSearch, cancelOrdersSearch } = useSearchInput(fullUrl, adminOptions)


const onSubmit = () => {
    handleOrdersSearch()
}
const onCancel = () => {
    cancelOrdersSearch()
}
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Заказы" />
            <div class="breadcrumbs">
                <a :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Заказы <span class="adm-fav-link"></span></h1>

            <form @submit.prevent="onSubmit" class="filter-form">
                <div class="filter-form__body">
                    <div class="row">
                        <div class="col-sm-6">
                            <RowInput v-model="dateFrom" name="date_from" type="date" label="Дата с" />
                        </div>
                        <div class="col-sm-6">
                            <RowInput v-model="dateTo" name="date_to" type="date" label="Дата по" />
                        </div>
                    </div>

                    <RowInput v-model="orderId" name="order_id" type="text" label="Номер заказа" />

                    <RowInput v-model="email" name="email" type="text" label="Емейл" />

                    <RowInput v-model="name" name="name" type="text" label="Имя" />

                    <RowSelect v-model="admin" name="admin_id" label="Менеджер" :options="withEmptyOption(authStore.adminOptions)" />
                </div>
                <div class="filter-form__footer">
                    <button type="submit" class="btn btn-primary mb-2 btn__default me-2">Найти</button>
                    <button type="button" @click="onCancel" class="btn btn-primary mb-2 btn__default me-2">Отменить</button>
                </div>
            </form>

            <div>
                <Link :href="route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_CREATE)" class="btn btn-primary mb-2 btn__save me-2">Добавить заказ</Link>

                <button type="button" @click="modalsStore.openModal(ModalType.SORT_ADMIN_COLUMNS, {type: ColumnType.adminOrderColumns})" class="btn btn-primary mb-2 me-2">Настроить</button>
            </div>
        </div>
    </TheLayout>
</template>
