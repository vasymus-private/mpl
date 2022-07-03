import { defineStore } from "pinia"
import BillStatus from "@/admin/inertia/modules/billStatuses/BillStatus"


export const storeName = "billStatuses"

export const useBillStatusesStore = defineStore(storeName, {
    state: () : { _entities: Array<BillStatus> } => {
        return {
            _entities: []
        }
    },
    getters: {
        entities: (state): Array<BillStatus> => state._entities
    },
    actions: {
        setEntities(entities: Array<BillStatus>): void {
            this._entities = entities
        }
    }
})
