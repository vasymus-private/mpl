<script lang="ts" setup>
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import RowSelect from "@/admin/inertia/components/forms/vee-validate/RowSelect.vue"
import {useOrderStatusesStore} from "@/admin/inertia/modules/orderStatuses"
import {ref} from 'vue'
import {useCreateEditOrderFormStore} from "@/admin/inertia/modules/forms/createEditOrder"
import {useRoutesStore} from "@/admin/inertia/modules/routes"
import {useToastsStore} from "@/admin/inertia/modules/toasts"


const ordersStore = useOrdersStore()
const orderStatusesStore = useOrderStatusesStore()
const createEditOrderFormStore = useCreateEditOrderFormStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()
const isOpen = ref<boolean>(false)
const cancelDescription = ref<string|null>(null)

const handleCancel = async (shouldCancel: boolean) => {
    let errorsOrVoid = await createEditOrderFormStore.handleCancel(
        shouldCancel,
        cancelDescription.value
    )

    if (!errorsOrVoid) {
        isOpen.value = false
        cancelDescription.value = null
        return
    }

    for (let key in errorsOrVoid) {
        toastsStore.error({
            title: key,
            message: errorsOrVoid[key]
        })
    }
}
const setIsOpen = () => {
    isOpen.value = true
}
const setIsNotOpen = () => {
    isOpen.value = false
    cancelDescription.value = null
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
                        <div v-if="!isOpen" class="col-sm-7 offset-sm-5 d-flex align-items-center mb-3">
                            <button @click="setIsOpen" type="button" class="btn btn__cancel-order">Отменить заказ</button>
                        </div>
                        <template v-if="isOpen">
                            <div class="col-sm-7 offset-sm-5 align-items-center mb-3">
                                <label for="cancel-reason" class="form-label">Причина отмены:</label>
                                <textarea v-model="cancelDescription" id="cancel-reason" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-sm-7 offset-sm-5 align-items-center">
                                <button @click="handleCancel(true)" type="button" class="btn btn-info">Отправить</button>
                                <button @click="setIsNotOpen" type="button" class="btn btn-secondary ms-2">Отменить</button>
                            </div>
                        </template>
                    </div>
                </template>
            </template>
        </div>
    </div>
</template>
