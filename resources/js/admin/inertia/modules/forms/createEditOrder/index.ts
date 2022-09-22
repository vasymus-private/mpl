import { defineStore } from "pinia"
import { useOrdersStore } from "@/admin/inertia/modules/orders"
import { useRoutesStore } from "@/admin/inertia/modules/routes"
import { UrlParams } from "@/admin/inertia/modules/common/types"
import { AdminTab, TabEnum } from "@/admin/inertia/modules/common/Tabs"
import OrderTab from "@/admin/inertia/components/orders/createEdit/tabs/OrderTab.vue"
import HistoryTab from "@/admin/inertia/components/orders/createEdit/tabs/HistoryTab.vue"
import * as yup from "yup"
import { Order } from "@/admin/inertia/modules/orders/types"
import { Values } from "@/admin/inertia/modules/forms/createEditOrder/types"

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
    },
})

export const getWatchOrderToFormCb =
    (setValues: (a: object) => any) => (order: Order | null) => {
        const {} = order || {}

        setValues({})
    }

export const getFormSchema = () => {
    return yup.object({})
}
