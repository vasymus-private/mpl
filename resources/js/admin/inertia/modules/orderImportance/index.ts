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
        orderImportance(state): (id: number) => OrderImportance|undefined {
            return (id:number) => this.entities.find(item => item.id === id)
        },
    },
    actions: {
        setEntities(entities: Array<OrderImportance>): void {
            this._entities = entities
        },
    },
})
