<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import RowInput from '@/admin/inertia/components/forms/native/RowInput.vue'
import RowSelect from '@/admin/inertia/components/forms/native/RowSelect.vue'
import {storeToRefs} from "pinia"
import {useAuthStore} from "@/admin/inertia/modules/auth"
import {getPerPageOptions, withEmptyOption} from "@/admin/inertia/modules/common"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import {Link} from "@inertiajs/inertia-vue3"
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {OrderItem} from "@/admin/inertia/modules/orders/types"
import {useColumnsStore, isSortableColumn, ColumnName} from "@/admin/inertia/modules/columns"
import {useOrderStatusesStore} from "@/admin/inertia/modules/orderStatuses"
import {useOrderImportanceStore} from "@/admin/inertia/modules/orderImportance"
import {usePaymentMethodsStore} from "@/admin/inertia/modules/paymentMethods"
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"


const ordersStore = useOrdersStore()
const routesStore = useRoutesStore()
const authStore = useAuthStore()
const modalsStore = useModalsStore()
const columnStore = useColumnsStore()
const orderStatusStore = useOrderStatusesStore()
const orderImportanceStore = useOrderImportanceStore()
const paymentsStore = usePaymentMethodsStore()

const {ordersList} = storeToRefs(ordersStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<OrderItem>(ordersList)

const {fullUrl} = storeToRefs(routesStore)
const {adminOptions} = storeToRefs(authStore)
const { dateFrom, dateTo, orderId, email, name, admin, handleOrdersSearch, cancelOrdersSearch, onPerPage } = useSearchInput(fullUrl, adminOptions)

const perPageOptions = getPerPageOptions()

const onSubmit = () => {
    handleOrdersSearch()
}
const onCancel = () => {
    cancelOrdersSearch()
}
const deleteOrder = (order: OrderItem) => {
    if (confirm(`Вы уверены, что хотите удалить заказ: №${order.id}?`)) {
        console.log('---- deleting order')
    }
}

const deleteOrders = () => {
    if (confirm('Вы уверены, что хотите удалить выбранные заказы.')) {
        console.log('---- deleting orders')
    }
}

watchSelectAll()
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

            <div class="admin-edit-variations table-responsive">
                <table class="table table-bordered table-hover js-order-busy-marker-wrapper" style="width: 2000px;">
                    <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check form-check-inline">
                                <input
                                    :disabled="editMode"
                                    v-model="selectAll"
                                    class="form-check-input position-static"
                                    type="checkbox">
                            </div>
                        </th>
                        <th scope="col">&nbsp;</th>
                        <th v-for="sortableColumn in columnStore.adminOrderColumns" :key="sortableColumn.value" scope="col">{{sortableColumn.label}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in ordersList" :key="order.id" @click="manualCheck(order.id)">
                        <td>
                            <div class="form-check">
                                <input
                                    :disabled="editMode"
                                    v-model="checkedItems"
                                    :value="order.id"
                                    class="form-check-input position-static js-product-item-checkbox"
                                    type="checkbox"
                                    @click.stop=""
                                />
                            </div>
                        </td>
                        <td>
                            <div class="dropdown" @click.stop="">
                                <button
                                    class="btn btn__grid-row-action-button dropdown-toggle"
                                    type="button"
                                    :id="`actions-dropdown-${order.id}`"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                ></button>
                                <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${order.id}`">
                                    <div class="bx-core-popup-menu__arrow"></div>
                                    <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_EDIT, {admin_order: order.id})">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Изменить</span>
                                    </Link>
                                    <div class="bx-core-popup-menu__arrow"></div>
                                    <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_CREATE, {copy_id: order.id})">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                        <span class="bx-core-popup-menu-item-text">Копировать</span>
                                    </Link>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="deleteOrder(order)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <template v-for="sortableColumn in columnStore.adminOrderColumns" :key="sortableColumn.value">
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.date_creation)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{order.created_at}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.id)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">
                                    <Link :href="route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_EDIT, {admin_order: order.id})" style="white-space: nowrap;">
                                        <span :class="[`js-order-busy-marker`, `js-order-busy-marker-${order.id}`]">
                                            <span v-if="order.is_busy_by_other_admin" style="display: inline-block; width: 20px; height: 20px; background-color: red; border-radius: 100%;"></span>
                                            <span v-else style="display: inline-block; width: 20px; height: 20px; background-color: green; border-radius: 100%;"></span>
                                        </span>
                                        №{{order.id}}
                                    </Link>
                                </span>
                            </td>
                            <td
                                v-if="isSortableColumn(sortableColumn, ColumnName.status)"
                                :class="`sortable-column-${sortableColumn.value}`"
                                :style="{backgroundColor: `${orderStatusStore.orderStatus(order.order_status_id)?.color}`}"
                            >
                                <span class="main-grid-cell-content">{{orderStatusStore.orderStatus(order.order_status_id)?.name}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.positions)" :class="`sortable-column-${sortableColumn.value}`">
                                <div class="main-grid-cell-content">
                                    <template v-for="orderItemProductItem in order.products" :key="orderItemProductItem.product.id">
                                        <p>
                                            {{ orderItemProductItem.order_product.name || orderItemProductItem.product.name }} <br />
                                            ({{ orderItemProductItem.order_product.count }} шт.)
                                        </p>
                                        <hr />
                                    </template>
                                </div>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.comment_admin)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{order.comment_admin}}</span>
                            </td>
                            <td
                                v-if="isSortableColumn(sortableColumn, ColumnName.importance)"
                                :class="`sortable-column-${sortableColumn.value}`"
                                :style="{backgroundColor: orderImportanceStore.orderImportance(order.importance_id)?.color}"
                            >
                                <span class="main-grid-cell-content">{{orderImportanceStore.orderImportance(order.importance_id)?.name}}</span>
                            </td>
                            <td
                                v-if="isSortableColumn(sortableColumn, ColumnName.manager)"
                                :class="`sortable-column-${sortableColumn.value}`"
                            >
                                <span class="main-grid-cell-content">
                                    <span
                                        :style="{
                                            backgroundColor: authStore.admin(order.admin_id)?.color || 'transparent',
                                            border: '1px solid black',
                                            padding: '3px 6px',
                                            borderRadius: '3px',
                                            width: '50px',
                                            display: 'inline-block',
                                            textAlign: 'center',
                                        }"
                                    >
                                        {{authStore.admin(order.admin_id)?.name}}
                                    </span>
                                </span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.sum)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{ordersStore.orderPriceRetailRubFormatted(order.id)}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.name)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{order.request_user_name || order.user_name}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.phone)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{order.request_user_phone || order.user_phone}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.email)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{order.request_user_email || order.user_email}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.comment_user)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{order.comment_user}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.payment_method)" :class="`sortable-column-${sortableColumn.value}`">
                                <span class="main-grid-cell-content">{{paymentsStore.paymentMethod(order.payment_method_id)?.name}}</span>
                            </td>
                        </template>
                    </tr>
                    </tbody>
                </table>
            </div>

            <Pagination
                v-if="ordersStore.meta"
                :total="ordersStore.meta.total"
                :current-page="ordersStore.meta.current_page"
                :per-page="ordersStore.getPerPageOption"
                :per-page-options="perPageOptions"
                :links="ordersStore.meta.links"
                @update:perPage="onPerPage"
            />

            <footer key="edit-mode-off" class="footer edit-item-footer">
                <button @click="deleteOrders" :disabled="!checkedItems.length" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
