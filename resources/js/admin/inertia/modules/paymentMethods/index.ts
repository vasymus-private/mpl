import { defineStore } from "pinia"
import PaymentMethod from "@/admin/inertia/modules/paymentMethods/PaymentMethod"

export const storeName = "paymentMethods"

export const usePaymentMethodsStore = defineStore(storeName, {
    state: (): { _entities: Array<PaymentMethod> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<PaymentMethod> => state._entities,
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
