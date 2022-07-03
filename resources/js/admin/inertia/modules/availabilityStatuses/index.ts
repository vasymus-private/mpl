import { defineStore } from "pinia"
import AvailabilityStatus from "@/admin/inertia/modules/availabilityStatuses/AvailabilityStatus"

export const storeName = "availabilityStatuses"

export const useAvailabilityStatusesStore = defineStore(storeName, {
    state: (): { _entities: Array<AvailabilityStatus> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<AvailabilityStatus> => state._entities,
    },
    actions: {
        setEntities(entities: Array<AvailabilityStatus>): void {
            this._entities = entities
        },
    },
})
