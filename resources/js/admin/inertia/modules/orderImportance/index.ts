import { defineStore } from "pinia"
import { OrderImportance } from "@/admin/inertia/modules/orderImportance/types"
import { Option } from "@/admin/inertia/modules/common/types"

export const storeName = "orderImportance"

export const useOrderImportanceStore = defineStore(storeName, {
    state: (): { _entities: Array<OrderImportance> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<OrderImportance> => state._entities,
        options: (state): Array<Option> =>
            state._entities.map((item) => ({
                value: item.id,
                label: item.name,
            })),
        orderImportance(state): (id: number) => OrderImportance | undefined {
            return (id: number) => this.entities.find((item) => item.id === id)
        },
    },
    actions: {
        setEntities(entities: Array<OrderImportance>): void {
            this._entities = entities
        },
    },
})
