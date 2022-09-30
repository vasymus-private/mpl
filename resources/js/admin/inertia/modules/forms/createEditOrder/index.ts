import { defineStore } from "pinia"
import { useOrdersStore } from "@/admin/inertia/modules/orders"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {ErrorResponse, UrlParams} from "@/admin/inertia/modules/common/types"
import { AdminTab, TabEnum } from "@/admin/inertia/modules/common/Tabs"
import OrderTab from "@/admin/inertia/components/orders/createEdit/tabs/OrderTab.vue"
import HistoryTab from "@/admin/inertia/components/orders/createEdit/tabs/HistoryTab.vue"
import * as yup from "yup"
import { Order } from "@/admin/inertia/modules/orders/types"
import { Values } from "@/admin/inertia/modules/forms/createEditOrder/types"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import axios, {AxiosError} from "axios";
import {errorsToErrorFields} from "@/admin/inertia/modules/common";

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
        ): Promise<void> {},
        async handleCancel(
            shouldCancel: boolean,
            cancelDescription?: string|null
        ): Promise<void | Record<string, string | undefined>> {
            const routesStore = useRoutesStore()
            const ordersStore = useOrdersStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_ORDERS_CANCEL,
                        {
                            admin_order: ordersStore.order.id
                        }
                    )
                )
                let response = await axios.put<{id: number, cancelled: boolean, cancelled_description: string|null}>(url.toString(), {
                    should_cancel: shouldCancel,
                    cancelled_description: cancelDescription,
                })

                ordersStore.updateOrder(response.data)
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
        const { order_status_id } = order || {}

        setValues({
            order_status_id,
        })
    }

export const getFormSchema = () => {
    return yup.object({
        order_status_id: yupIntegerOrEmptyString(),
    })
}
