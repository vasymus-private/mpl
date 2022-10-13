import { defineStore } from "pinia"
import { useOrdersStore } from "@/admin/inertia/modules/orders"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import {
    ErrorResponse,
    UrlParams,
    Media,
    AdminTab,
    TabEnum,
} from "@/admin/inertia/modules/common/types"
import OrderTab from "@/admin/inertia/components/orders/createEdit/tabs/OrderTab.vue"
import HistoryTab from "@/admin/inertia/components/orders/createEdit/tabs/HistoryTab.vue"
import * as yup from "yup"
import { Order } from "@/admin/inertia/modules/orders/types"
import { Values } from "@/admin/inertia/modules/forms/createEditOrder/types"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import axios, { AxiosError } from "axios"
import {
    errorsToErrorFields,
    getMediaSchema,
} from "@/admin/inertia/modules/common"
import { useAuthStore } from "@/admin/inertia/modules/auth"
import { CustomFormData } from "@/admin/inertia/utils/CustomFormData"
import { Inertia } from "@inertiajs/inertia"

export const storeName = "createEditOrderForm"

export const useCreateEditOrderFormStore = defineStore(storeName, {
    getters: {
        orderFormTitle: (): string => {
            const ordersStore = useOrdersStore()

            if (ordersStore.isCreatingFromCopy) {
                return "Добавление заказа копированием"
            }

            if (ordersStore.isCreatingOrderRoute) {
                return "Добавление заказа"
            }

            return `Заказ №${ordersStore.order?.id}`
        },
        isEditMode: (): boolean => {
            const routesStore = useRoutesStore()

            return !!routesStore.urlParam(UrlParams.edit_mode)
        },
        allAdminTabs: (): Array<AdminTab> => {
            return [
                {
                    value: TabEnum.order,
                    label: "Заказ",
                    is: OrderTab,
                },
                {
                    value: TabEnum.history,
                    label: "История изменений",
                    is: HistoryTab,
                },
            ]
        },
        couldBeChangedByAdmin: (): boolean => {
            const ordersStore = useOrdersStore()
            const authStore = useAuthStore()

            const isBusyByOtherAdmin: boolean = ordersStore.order
                ? ordersStore.order.is_busy_by_other_admin
                : false

            return (
                ordersStore.isCreatingOrderRoute ||
                !isBusyByOtherAdmin ||
                authStore.auth.user.is_super_admin
            )
        },
    },
    actions: {
        toggleEditMode: function (): void {
            const routesStore = useRoutesStore()

            routesStore.replaceUrlParamState(
                UrlParams.edit_mode,
                !this.isEditMode
            )
        },
        async submitCreateEditOrder(
            values: Values,
            { setErrors }
        ): Promise<void> {
            const ordersStore = useOrdersStore()

            try {
                let order: Order

                const formData = valuesToFormData(values)
                const routesStore = useRoutesStore()

                if (ordersStore.isCreatingOrderRoute) {
                    const response = await axios.post<{ data: Order }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_ORDERS_STORE
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )

                    order = response.data.data

                    Inertia.get(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_ORDERS_TEMP_EDIT,
                            {
                                admin_order: order.id,
                            }
                        )
                    )
                } else {
                    formData.append("_method", "PUT")
                    const response = await axios.post<{ data: Order }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_ORDERS_UPDATE,
                            {
                                admin_order: values.id,
                            }
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )

                    order = response.data.data
                    ordersStore.setOrder(order)
                    await ordersStore.fetchOrderEvents()
                }
            } catch (e) {
                if (e instanceof AxiosError) {
                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    const errorFields = errorsToErrorFields(errors)

                    setErrors(errorFields)
                    return
                }
                throw e
            }
        },
        async handleCancel(
            shouldCancel: boolean,
            cancelDescription?: string | null
        ): Promise<void | Record<string, string | undefined>> {
            const routesStore = useRoutesStore()
            const ordersStore = useOrdersStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_ORDERS_CANCEL,
                        {
                            admin_order: ordersStore.order.id,
                        }
                    )
                )
                let response = await axios.put<{
                    id: number
                    cancelled: boolean
                    cancelled_description: string | null
                    updated_at: string | null
                }>(url.toString(), {
                    should_cancel: shouldCancel,
                    cancelled_description: cancelDescription,
                })

                ordersStore.updateOrder(response.data)

                await ordersStore.fetchOrderEvents()
            } catch (e) {
                if (e instanceof AxiosError) {
                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    return errorsToErrorFields(errors)
                }
                throw e
            }
        },
    },
})

export const getWatchOrderToFormCb =
    (setValues: (a: object) => any) => (order: Order | null) => {
        const {
            id,
            order_status_id,
            request_user_email,
            request_user_name,
            request_user_phone,
            payment_method_id,
            comment_user,
            admin_id,
            importance_id,
            customer_bill_description,
            customer_bill_status_id,
            customer_invoices = [],
            provider_bill_description,
            provider_bill_status_id,
            supplier_invoices = [],
            comment_admin,
            products = [],
        } = order || {}

        setValues({
            id,
            order_status_id,
            request_user_email,
            request_user_name,
            request_user_phone,
            payment_method_id,
            comment_user,
            admin_id,
            importance_id,
            customer_bill_description,
            customer_bill_status_id,
            customer_invoices,
            provider_bill_description,
            provider_bill_status_id,
            supplier_invoices,
            comment_admin,
            products,
        })
    }

export const getFormSchema = () => {
    return yup.object({
        id: yupIntegerOrEmptyString(),
        order_status_id: yup.number().integer().required(),
        request_user_email: yup.string().nullable(),
        request_user_name: yup.string().nullable(),
        request_user_phone: yup.string().nullable(),
        payment_method_id: yup.number().integer().required(),
        comment_user: yup.string().nullable(),
        admin_id: yupIntegerOrEmptyString(),
        importance_id: yupIntegerOrEmptyString(),
        customer_bill_description: yup.string().nullable(),
        customer_bill_status_id: yup.number().integer().required(),
        customer_invoices: yup.array().of(getMediaSchema()).nullable(),
        provider_bill_description: yup.string().nullable(),
        provider_bill_status_id: yup.number().integer().required(),
        supplier_invoices: yup.array().of(getMediaSchema()).nullable(),
        comment_admin: yup.string().nullable(),
        products: yup.array().of(getOrderProductSchema()),
    })
}

export const getOrderProductSchema = () => {
    return yup.object({
        id: yup.number().integer(),
        uuid: yup.string(),
        price_purchase: yup.number(),
        price_purchase_currency_id: yup.number().integer(),
        order_product_count: yup.number(),
        order_product_name: yup.string().nullable(),
        order_product_unit: yup.string().nullable(),
        order_product_ordering: yup.number().integer(),
        order_product_price_retail_rub: yup.number(),
        order_product_price_retail_rub_origin: yup.number(),
        order_product_price_retail_rub_was_updated: yup.boolean(),
    })
}

const valuesToFormData = (values: Values): FormData => {
    const formData = new CustomFormData()

    let stringOrNumberKeys: Array<keyof Values> = [
        "order_status_id",
        "request_user_email",
        "request_user_name",
        "request_user_phone",
        "payment_method_id",
        "comment_user",
        "admin_id",
        "importance_id",
        "customer_bill_description",
        "customer_bill_status_id",
        "provider_bill_description",
        "provider_bill_status_id",
        "comment_admin",
    ]

    stringOrNumberKeys.forEach((key) => {
        let value = values[key] as string | number | null | undefined
        formData.setStringOrNumber(key, value)
    })

    if (values.customer_invoices) {
        values.customer_invoices.forEach((item: Media, index: number) => {
            formData.appendStringOrNumber(
                `customerInvoices[${index}][id]`,
                item.id
            )
            formData.appendStringOrNumber(
                `customerInvoices[${index}][uuid]`,
                item.uuid
            )
            formData.appendStringOrNumber(
                `customerInvoices[${index}][name]`,
                item.name
            )
            formData.appendStringOrNumber(
                `customerInvoices[${index}][file_name]`,
                item.file_name
            )
            formData.appendStringOrNumber(
                `customerInvoices[${index}][order_column]`,
                item.order_column
            )

            formData.appendFile(`customerInvoices[${index}][file]`, item.file)
        })
    }

    if (values.supplier_invoices) {
        values.supplier_invoices.forEach((item: Media, index: number) => {
            formData.appendStringOrNumber(
                `supplierInvoices[${index}][id]`,
                item.id
            )
            formData.appendStringOrNumber(
                `supplierInvoices[${index}][uuid]`,
                item.uuid
            )
            formData.appendStringOrNumber(
                `supplierInvoices[${index}][name]`,
                item.name
            )
            formData.appendStringOrNumber(
                `supplierInvoices[${index}][file_name]`,
                item.file_name
            )
            formData.appendStringOrNumber(
                `supplierInvoices[${index}][order_column]`,
                item.order_column
            )

            formData.appendFile(`supplierInvoices[${index}][file]`, item.file)
        })
    }

    if (values.products) {
        values.products.forEach((product, index) => {
            formData.appendStringOrNumber(
                `products[${index}][uuid]`,
                product.uuid
            )
            formData.appendStringOrNumber(
                `products[${index}][count]`,
                product.order_product_count
            )
            formData.appendStringOrNumber(
                `products[${index}][name]`,
                product.order_product_name
            )
            formData.appendStringOrNumber(
                `products[${index}][unit]`,
                product.order_product_unit
            )
            formData.appendStringOrNumber(
                `products[${index}][ordering]`,
                product.order_product_ordering
            )
            formData.appendStringOrNumber(
                `products[${index}][price_retail_rub]`,
                product.order_product_price_retail_rub
            )
            formData.appendBoolean(
                `products[${index}][price_retail_rub_was_updated]`,
                product.order_product_price_retail_rub_was_updated
            )
        })
    }

    return formData
}
