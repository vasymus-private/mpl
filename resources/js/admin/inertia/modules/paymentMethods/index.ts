import { defineStore } from "pinia"
import { PaymentMethod } from "@/admin/inertia/modules/paymentMethods/types"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "paymentMethods"

export const usePaymentMethodsStore = defineStore(storeName, {
    state: (): { _entities: Array<PaymentMethod> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<PaymentMethod> => state._entities,
        options: (state): Array<Option> =>
            state._entities.map((pm) => ({ value: pm.id, label: pm.name })),
        paymentMethod: function () {
            return (id: number): PaymentMethod | undefined => {
                return this.entities.find((item) => item.id === id)
            }
        },
    },
    actions: {
        setEntities(entities: Array<PaymentMethod>): void {
            this._entities = entities
        },
    },
})
