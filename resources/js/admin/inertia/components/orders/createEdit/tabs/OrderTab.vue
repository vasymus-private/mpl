<script lang="ts" setup>
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import RowSelect from "@/admin/inertia/components/forms/vee-validate/RowSelect.vue"
import {useOrderStatusesStore} from "@/admin/inertia/modules/orderStatuses"
import {computed, ref} from 'vue'
import {useCreateEditOrderFormStore} from "@/admin/inertia/modules/forms/createEditOrder"
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import RowInput from "@/admin/inertia/components/forms/vee-validate/RowInput.vue"
import {usePaymentMethodsStore} from "@/admin/inertia/modules/paymentMethods"
import RowTextarea from "@/admin/inertia/components/forms/vee-validate/RowTextarea.vue"
import {useAuthStore} from "@/admin/inertia/modules/auth"
import {useOrderImportanceStore} from "@/admin/inertia/modules/orderImportance"
import {useBillStatusesStore} from "@/admin/inertia/modules/billStatuses"
import RowMedias from "@/admin/inertia/components/forms/vee-validate/RowMedias.vue"


const ordersStore = useOrdersStore()
const orderStatusesStore = useOrderStatusesStore()
const createEditOrderFormStore = useCreateEditOrderFormStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()
const paymentMethodsStore = usePaymentMethodsStore()
const authStore = useAuthStore()
const orderImportanceStore = useOrderImportanceStore()
const billStatusesStore = useBillStatusesStore()

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

const editing = computed<boolean>(() => ordersStore.isCreatingOrderRoute || createEditOrderFormStore.isEditMode)
const showAdditionalFiles = computed<boolean>(() => !ordersStore.isCreatingOrderRoute || !createEditOrderFormStore.isEditMode && (!!ordersStore.order?.initial_attachments.length && !!ordersStore.order?.payment_method_attachments.length))
</script>

<template>
    <div class="item-edit order-edit">
        <div class="adm-bus-component-title-container">
            <div class="adm-bus-component-title-icon"></div>
            <span class="adm-bus-component-title">Параметры заказа</span>
        </div>

        <div class="adm-bus-component-content-container">
            <div v-if="!ordersStore.isCreatingOrderRoute" class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Номер заказа:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.id }}
                </div>
            </div>

            <div v-if="!ordersStore.isCreatingOrderRoute" class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Создан:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.dt_created_at ? ordersStore.order.dt_created_at.toFormat('yyyy-LL-dd HH:mm:ss') : '' }}
                </div>
            </div>

            <div v-if="!ordersStore.isCreatingOrderRoute" class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Последнее изменение:</label>
                </div>
                <div class="col-sm-7">
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

        <div class="adm-bus-component-title-container">
            <div class="adm-bus-component-title-icon"></div>
            <span class="adm-bus-component-title">Покупатель</span>
        </div>

        <div class="adm-bus-component-content-container">
            <RowInput
                v-if="editing"
                name="request_user_email"
                label="E-mail (логин)"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>E-mail (логин):</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.request_user_email }}
                </div>
            </div>

            <RowInput
                v-if="editing"
                name="request_user_name"
                label="Имя"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Имя:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.request_user_name }}
                </div>
            </div>

            <RowInput
                v-if="editing"
                name="request_user_phone"
                label="Телефон"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Телефон:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.request_user_phone }}
                </div>
            </div>

            <RowSelect
                v-if="editing"
                name="payment_method_id"
                label="Способ оплаты"
                :options="paymentMethodsStore.options"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Способ оплаты:</label>
                </div>
                <div class="col-sm-7">
                    {{ paymentMethodsStore.paymentMethod(ordersStore.order?.payment_method_id)?.name }}
                </div>
            </div>

            <RowTextarea
                v-if="editing"
                name="comment_user"
                label="Комментарий пользователя"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Комментарий пользователя:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.comment_user }}
                </div>
            </div>

            <div v-if="showAdditionalFiles" class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Прикрепленные файлы к заказу:</label>
                </div>
                <div class="col-sm-7">
                    <p v-for="media in ordersStore.order?.initial_attachments" class="mb-0" :key="media.uuid">
                        <a target="_blank" download :href="route(routeNames.ROUTE_ADMIN_MEDIA, {id: media.id, name: media.name})">{{media.name}}</a>
                    </p>
                    <p v-for="media in ordersStore.order?.payment_method_attachments" class="mb-0" :key="media.uuid">
                        <a target="_blank" download :href="route(routeNames.ROUTE_ADMIN_MEDIA, {id: media.id, name: media.name})">{{media.name}}</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="adm-bus-component-title-container">
            <div class="adm-bus-component-title-icon"></div>
            <span class="adm-bus-component-title">Служебные поля</span>
        </div>

        <div class="adm-bus-component-content-container">
            <RowSelect
                v-if="editing"
                name="admin_id"
                label="Менеджер"
                :options="authStore.adminOptions"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Менеджер:</label>
                </div>
                <div class="col-sm-7">
                    {{ authStore.admin(ordersStore.order?.admin_id)?.name }}
                </div>
            </div>

            <RowSelect
                v-if="editing"
                name="importance_id"
                label="Важность"
                :options="orderImportanceStore.options"
            />
            <div v-else class="row mb-3" :style="{ backgroundColor: orderImportanceStore.orderImportance(ordersStore.order?.importance_id)?.color || 'transparent' }">
                <div class="col-sm-5 text-end">
                    <label>Важность:</label>
                </div>
                <div class="col-sm-7">
                    {{ orderImportanceStore.orderImportance(ordersStore.order?.importance_id)?.name }}
                </div>
            </div>

            <RowTextarea
                v-if="editing"
                name="customer_bill_description"
                label="Счёт покупателю"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Счёт покупателю:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.customer_bill_description }}
                </div>
            </div>

            <RowSelect
                v-if="editing"
                name="customer_bill_status_id"
                label="Статус счёта покупателю"
                :options="billStatusesStore.options"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Статус счёта покупателю:</label>
                </div>
                <div class="col-sm-7">
                    {{ billStatusesStore.billStatus(ordersStore.order?.customer_bill_status_id)?.name }}
                </div>
            </div>

            <RowMedias
                v-if="editing"
                name="customer_invoices"
                label="Приложенные файлы"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Приложенные файлы:</label>
                </div>
                <div class="col-sm-7">
                    <p v-for="media in ordersStore.order?.customer_invoices" class="mb-0" :key="media.uuid">
                        <a target="_blank" download :href="route(routeNames.ROUTE_ADMIN_MEDIA, {id: media.id, name: media.name})">{{media.name}}</a>
                    </p>
                </div>
            </div>

            <RowTextarea
                v-if="editing"
                name="provider_bill_description"
                label="Счёт от поставщика"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Счёт от поставщика:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.provider_bill_description }}
                </div>
            </div>

            <RowSelect
                v-if="editing"
                name="provider_bill_status_id"
                label="Статус счёта поставщика"
                :options="billStatusesStore.options"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Статус счёта поставщика:</label>
                </div>
                <div class="col-sm-7">
                    {{ billStatusesStore.billStatus(ordersStore.order?.provider_bill_status_id)?.name }}
                </div>
            </div>

            <RowMedias
                v-if="editing"
                name="supplier_invoices"
                label="Приложенные файлы"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Приложенные файлы:</label>
                </div>
                <div class="col-sm-7">
                    <p v-for="media in ordersStore.order?.supplier_invoices" class="mb-0" :key="media.uuid">
                        <a target="_blank" download :href="route(routeNames.ROUTE_ADMIN_MEDIA, {id: media.id, name: media.name})">{{media.name}}</a>
                    </p>
                </div>
            </div>

            <RowTextarea
                v-if="editing"
                name="comment_admin"
                label="Комментарий менеджера"
            />
            <div v-else class="row mb-3">
                <div class="col-sm-5 text-end">
                    <label>Комментарий менеджера:</label>
                </div>
                <div class="col-sm-7">
                    {{ ordersStore.order?.comment_admin }}
                </div>
            </div>
        </div>
    </div>
</template>
