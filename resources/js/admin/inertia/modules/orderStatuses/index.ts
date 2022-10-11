import { defineStore } from "pinia"
import { OrderStatus } from "@/admin/inertia/modules/orderStatuses/types"
import {Option} from "@/admin/inertia/modules/common/types"

export const storeName = "orderStatuses"

export const useOrderStatusesStore = defineStore(storeName, {
    state: (): { _entities: Array<OrderStatus> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<OrderStatus> => state._entities,
        options: function (): Array<Option> {
            return this.entities.map(
                (item: OrderStatus): Option => ({
                    value: item.id,
                    label: item.name,
                })
            )
        },
        orderStatus(): (id: number) => OrderStatus | undefined {
            return (id) => {
                return this.entities.find((item) => item.id === id)
            }
        },
    },
    actions: {
        setEntities(entities: Array<OrderStatus>): void {
            this._entities = entities
        },
    },
})
