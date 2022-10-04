<script lang="ts" setup>
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import RowSelect from "@/admin/inertia/components/forms/vee-validate/RowSelect.vue"
import {useOrderStatusesStore} from "@/admin/inertia/modules/orderStatuses"
import {computed, ref} from 'vue'
import {useCreateEditOrderFormStore} from "@/admin/inertia/modules/forms/createEditOrder"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import RowInput from "@/admin/inertia/components/forms/vee-validate/RowInput.vue"
import {usePaymentMethodsStore} from "@/admin/inertia/modules/paymentMethods"
import RowTextarea from "@/admin/inertia/components/forms/vee-validate/RowTextarea.vue"
import {useAuthStore} from "@/admin/inertia/modules/auth"
import {useOrderImportanceStore} from "@/admin/inertia/modules/orderImportance"
import {useBillStatusesStore} from "@/admin/inertia/modules/billStatuses"
import RowMedias from "@/admin/inertia/components/forms/vee-validate/RowMedias.vue"
import {FieldEntry, useFieldArray} from "vee-validate"
import {OrderProductItem} from "@/admin/inertia/modules/orders/types"
import FormControlInput from "@/admin/inertia/components/forms/vee-validate/FormControlInput.vue"
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import {CharCode} from "@/admin/inertia/modules/currencies/types"
import {ModalType} from "@/admin/inertia/modules/modals/types"
import {useModalsStore} from "@/admin/inertia/modules/modals"


const ordersStore = useOrdersStore()
const orderStatusesStore = useOrderStatusesStore()
const createEditOrderFormStore = useCreateEditOrderFormStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()
const paymentMethodsStore = usePaymentMethodsStore()
const authStore = useAuthStore()
const orderImportanceStore = useOrderImportanceStore()
const billStatusesStore = useBillStatusesStore()
const currenciesStore = useCurrenciesStore()
const modalsStore = useModalsStore()

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

const {fields : productsFields, remove, swap} = useFieldArray<Partial<OrderProductItem>>('products')

const addProduct = () => {
    modalsStore.openModal(ModalType.ADD_ORDER_PRODUCT_ITEM, {})
}
const editProduct = (idx) => {
    modalsStore.openModal(ModalType.EDIT_ORDER_PRODUCT, {
        index: idx
    })
}
const deleteProduct = (idx) => {
    remove(idx)
}

const orderProductItemPricePurchaseRubFormatted = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): string => {
    return currenciesStore.priceRubFormatted(
        orderProductItem.value.price_purchase,
        orderProductItem.value.price_purchase_currency_id
    )
}
const orderProductItemPriceRetailRubSum = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): number => {
    return orderProductItem.value.order_product_price_retail_rub * orderProductItem.value.order_product_count
}
const orderProductItemPriceRetailRubSumFormatted = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): string => {
    return currenciesStore.priceRubFormatted(
        orderProductItemPriceRetailRubSum(orderProductItem),
        CharCode.RUB
    )
}
const orderProductItemPricePurchaseRubSum = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): number => {
    let pricePurchase = currenciesStore.priceRub(orderProductItem.value.price_purchase, orderProductItem.value.price_purchase_currency_id)

    return pricePurchase * orderProductItem.value.order_product_count
}
const orderProductItemPricePurchaseRubSumFormatted = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): string => {
    return currenciesStore.priceRubFormatted(
        orderProductItemPricePurchaseRubSum(orderProductItem),
        CharCode.RUB
    )
}
const orderProductItemProfitRubFormatted = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): string => {
    const pricePurchaseRubSum = orderProductItemPricePurchaseRubSum(orderProductItem)
    const priceRetailRubSum = orderProductItemPriceRetailRubSum(orderProductItem)

    const profitRub = priceRetailRubSum - pricePurchaseRubSum

    return currenciesStore.priceRubFormatted(
        profitRub,
        CharCode.RUB
    )
}
const orderProductPriceRetailRubFormatted = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): string => {
    return currenciesStore.priceRubFormatted(
        orderProductItem.value.order_product_price_retail_rub,
        CharCode.RUB
    )
}
const orderProductPriceRetailRubOriginFormatted = (orderProductItem: FieldEntry<Partial<OrderProductItem>>): string => {
    return currenciesStore.priceRubFormatted(
        orderProductItem.value.order_product_price_retail_rub_origin,
        CharCode.RUB
    )
}

const orderTotalPriceRetailRub = computed<number>(() => {
    return productsFields.value.reduce((acc: number, orderProductItem: FieldEntry<Partial<OrderProductItem>>): number => {
        return acc + orderProductItemPriceRetailRubSum(orderProductItem)
    }, 0)
})
const orderTotalPriceRetailRubFormatted = computed<string>(() => {
    return currenciesStore.priceRubFormatted(
        orderTotalPriceRetailRub.value,
        CharCode.RUB
    )
})
const orderTotalPricePurchaseRub = computed<number>(() => {
    return productsFields.value.reduce((acc: number, orderProductItem: FieldEntry<Partial<OrderProductItem>>): number => {
        return acc + orderProductItemPricePurchaseRubSum(orderProductItem)
    }, 0)
})
const orderTotalPricePurchaseRubFormatted = computed<string>(() => {
    return currenciesStore.priceRubFormatted(
        orderTotalPricePurchaseRub.value,
        CharCode.RUB
    )
})
const orderTotalProfitRubFormatted = computed<string>(() => {
    return currenciesStore.priceRubFormatted(
        orderTotalPriceRetailRub.value - orderTotalPricePurchaseRub.value,
        CharCode.RUB
    )
})
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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
                :keep-value="true"
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

        <div class="adm-bus-component-title-container">
            <div class="adm-bus-component-title-icon"></div>
            <span class="adm-bus-component-title">Состав заказа</span>
        </div>

        <div class="adm-bus-component-content-container">
            <div v-if="editing" class="search form-group row justify-content-end">
                <div class="col-xs-12 col-sm-2">
                    <div class="dropdown">
                        <button type="button" @click="addProduct" class="btn btn-add btn-secondary">Добавить товар</button>
                    </div>
                </div>
            </div>

            <table class="table adm-s-order-table-ddi-table">
                <thead>
                    <tr>
                        <th v-if="editing" scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                        <th scope="col">&uarr;&darr;</th>
                        <th scope="col">Название</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Свойства</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(productField, idx) in productsFields" :key="productField.value.uuid">
                        <td v-if="editing">
                            <div class="dropdown" @click.stop="">
                                <button
                                    class="btn btn__grid-row-action-button dropdown-toggle"
                                    type="button"
                                    :id="`actions-dropdown-${productField.value.uuid}`"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                ></button>
                                <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${productField.value.uuid}`">
                                    <button @click="editProduct(idx)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Изменить</span>
                                    </button>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="deleteProduct(productField)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="buttons-block">
                                <button
                                    :disabled="productField.isFirst"
                                    type="button"
                                    class="btn btn__default"
                                    @click="swap(idx, idx - 1)"
                                >&uarr;</button>
                                <button
                                    :disabled="productField.isLast"
                                    type="button"
                                    class="btn btn__default"
                                    @click="swap(idx, idx + 1)"
                                >&darr;</button>
                            </div>
                        </td>
                        <td>
                            <span class="main-grid-cell-content">
                                <a
                                    target="_blank"
                                    :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: productField.value.id})"
                                >{{productField.value.order_product_name}}</a>
                            </span>
                        </td>
                        <td>
                            <FormControlInput
                                v-if="editing"
                                :name="`products[${idx}].order_product_count`"
                                type="text"
                                :keep-value="true"
                            />
                            <span v-else class="main-grid-cell-content">{{productField.value.order_product_count}}</span>
                        </td>
                        <td>
                            <template v-if="editing">
                                <p>Закупочная: {{orderProductItemPricePurchaseRubFormatted(productField)}}</p>
                                <p>Сумма закупки: {{orderProductItemPricePurchaseRubSumFormatted(productField)}}</p>
                                <p>Заработок: {{orderProductItemProfitRubFormatted(productField)}}</p>
                            </template>
                            <template v-else>
                                <p>Закупочная: {{ordersStore.orderProductItemPricePurchaseRubFormatted(productField.value.uuid)}}</p>
                                <p>Сумма закупки: {{ordersStore.orderProductItemPricePurchaseRubSumFormatted(productField.value.uuid)}}</p>
                                <p>Заработок: {{ordersStore.orderProductItemProfitRubFormatted(productField.value.uuid)}}</p>
                            </template>
                        </td>
                        <td>
                            <FormControlInput
                                v-if="editing"
                                :name="`products[${idx}].order_product_price_retail_rub`"
                                type="text"
                                :keep-value="true"
                            />
                            <p v-else>
                                <span class="main-grid-cell-content">{{orderProductPriceRetailRubFormatted(productField)}}</span>
                            </p>

                            <p v-if="productField.value.order_product_price_retail_rub_was_updated" :style="{textDecoration: 'line-through'}">
                                <span class="main-grid-cell-content">{{orderProductPriceRetailRubOriginFormatted(productField)}}</span>
                            </p>
                        </td>
                        <td>
                            <span v-if="editing" class="main-grid-cell-content">{{orderProductItemPriceRetailRubSumFormatted(productField)}}</span>
                            <span v-else class="main-grid-cell-content">{{ordersStore.orderProductItemPriceRetailRubSumFormatted(productField.value.uuid)}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row-line row-line__right">
            <div class="adm-s-result-container-itog-table py-2">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Розничная стоимость товаров:</th>
                        <th>
                            <template v-if="editing">
                                {{ orderTotalPriceRetailRubFormatted }}
                            </template>
                            <template v-else>
                                {{ ordersStore.orderTotalPriceRetailRubFormatted }}
                            </template>
                        </th>
                    </tr>
                    <tr>
                        <th>Закупочная стоимость товаров:</th>
                        <th>
                            <template v-if="editing">
                                {{ orderTotalPricePurchaseRubFormatted }}
                            </template>
                            <template v-else>
                                {{ ordersStore.orderTotalPricePurchaseRubFormatted }}
                            </template>
                        </th>
                    </tr>
                    <tr>
                        <th>Заработок:</th>
                        <th>
                            <template v-if="editing">
                                {{ orderTotalProfitRubFormatted }}
                            </template>
                            <template v-else>
                                {{ ordersStore.orderTotalProfitRubFormatted }}
                            </template>
                        </th>
                    </tr>
                    <tr class="adm-s-result-container-itog-table-result">
                        <th>Итого к оплате:</th>
                        <th>
                            <template v-if="editing">
                                {{ orderTotalPriceRetailRubFormatted }}
                            </template>
                            <template v-else>
                                {{ ordersStore.orderTotalPriceRetailRubFormatted }}
                            </template>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
