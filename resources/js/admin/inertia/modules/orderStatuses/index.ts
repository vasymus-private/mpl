import { defineStore } from "pinia"
import { OrderStatus } from "@/admin/inertia/modules/orderStatuses/types"

export const storeName = "orderStatuses"

export const useOrderStatusesStore = defineStore(storeName, {
    state: (): { _entities: Array<OrderStatus> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<OrderStatus> => state._entities,
    },
    actions: {
        setEntities(entities: Array<OrderStatus>): void {
            this._entities = entities
        },
    },
})
