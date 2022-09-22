<script lang="ts" setup>
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import RowSelect from "@/admin/inertia/components/forms/vee-validate/RowSelect.vue"
import {useOrderStatusesStore} from "@/admin/inertia/modules/orderStatuses"
import {ref} from 'vue'


const ordersStore = useOrdersStore()
const orderStatusesStore = useOrderStatusesStore()
const isOpen = ref<boolean>(false)
const cancelReason = ref<string|null>(null)
const handleCancel = (shouldCancel: boolean) => {

}
</script>

<template>
    <div class="item-edit order-edit">
        <div class="adm-bus-component-title-container">
            <div class="adm-bus-component-title-icon"></div>
            <span class="adm-bus-component-title">Параметры заказа</span>
        </div>

        <div class="adm-bus-component-content-container">
            <div v-if="!ordersStore.isCreatingOrderRoute" class="form-group row">
                <label class="col-sm-5 col-form-label">Номер заказа:</label>
                <div class="col-sm-7 d-flex align-items-center">
                    {{ ordersStore.order?.id }}
                </div>
            </div>

            <div v-if="!ordersStore.isCreatingOrderRoute" class="form-group row">
                <label class="col-sm-5 col-form-label">Создан:</label>
                <div class="col-sm-7 d-flex align-items-center">
                    {{ ordersStore.order?.dt_created_at ? ordersStore.order.dt_created_at.toFormat('yyyy-LL-dd HH:mm:ss') : '' }}
                </div>
            </div>

            <div v-if="!ordersStore.isCreatingOrderRoute" class="form-group row">
                <label class="col-sm-5 col-form-label">Последнее изменение:</label>
                <div class="col-sm-7 d-flex align-items-center">
                    {{ ordersStore.order?.dt_updated_at ? ordersStore.order.dt_updated_at.toFormat('yyyy-LL-dd HH:mm:ss') : '' }}
                </div>
            </div>

            <RowSelect
                name="order_status_id"
                label="Статус заказа"
                :options="orderStatusesStore.options"
            />

            <template v-if="!ordersStore.isCreatingOrderRoute">
                <template v-if="ordersStore.order?.cancelled">
                    <div class="row mb-3">
                        <div class="col-sm-5 text-end">
                            <label><span class="bg-danger d-inline-block p-1 rounded">Заказ отменён: Да</span></label>
                        </div>
                        <div class="col-sm-7">
                            <button @click="handleCancel(false)" type="button" class="btn btn-primary">Снять отмену заказа</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-end">
                            <label>Причина отмены:</label>
                        </div>
                        <div class="col-sm-7">
                            {{ ordersStore.order?.cancelled_description }}
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="form-group row">
                        <div class="col-sm-7 offset-sm-5 d-flex align-items-center">
                            <button @click="isOpen = true" type="button" class="btn btn__cancel-order">Отменить заказ</button>
                        </div>
                        <div v-if="isOpen" class="col-sm-7 offset-sm-5 d-flex align-items-center">
                            <input v-bind="cancelReason" class="form-control" type="text" />
                        </div>
                        <div class="col-sm-7 offset-sm-5 d-flex align-items-center">
                            <button @click="handleCancel(true)" type="button" class="btn btn-info">Отправить</button>
                            <button @click="isOpen = false" type="button" class="btn btn-secondary">Отменить заказ</button>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
</template>
