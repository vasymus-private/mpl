import { defineStore } from "pinia"
import AvailabilityStatus from "@/admin/inertia/modules/availabilityStatuses/AvailabilityStatus"
import Option from "@/admin/inertia/modules/common/Option";

export const storeName = "availabilityStatuses"

export const useAvailabilityStatusesStore = defineStore(storeName, {
    state: (): { _entities: Array<AvailabilityStatus> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<AvailabilityStatus> => state._entities,
        options: function (): Array<Option> {
            return this.entities.map((availabilityStatus: AvailabilityStatus): Option => ({value: availabilityStatus.id, label: availabilityStatus.name, disabled: false}))
        },
    },
    actions: {
        setEntities(entities: Array<AvailabilityStatus>): void {
            this._entities = entities
        },
    },
})
