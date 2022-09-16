import { defineStore } from "pinia"
import { OrderImportance } from "@/admin/inertia/modules/orderImportance/types"

export const storeName = "orderImportance"

export const useOrderImportanceStore = defineStore(storeName, {
    state: (): { _entities: Array<OrderImportance> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<OrderImportance> => state._entities,
    },
    actions: {
        setEntities(entities: Array<OrderImportance>): void {
            this._entities = entities
        },
    },
})
