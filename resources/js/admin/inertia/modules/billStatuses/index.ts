import { defineStore } from "pinia"
import { BillStatus } from "@/admin/inertia/modules/billStatuses/types"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "billStatuses"

export const useBillStatusesStore = defineStore(storeName, {
    state: (): { _entities: Array<BillStatus> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<BillStatus> => state._entities,
        billStatus() {
            return (id): BillStatus | undefined =>
                this.entities.find((item) => item.id === id)
        },
        options: (state): Array<Option> =>
            state._entities.map((item) => ({
                value: item.id,
                label: item.name,
            })),
    },
    actions: {
        setEntities(entities: Array<BillStatus>): void {
            this._entities = entities
        },
    },
})
