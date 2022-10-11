import { defineStore } from "pinia"
import { AvailabilityStatus } from "@/admin/inertia/modules/availabilityStatuses/types"
import {Option} from "@/admin/inertia/modules/common/types"

export const storeName = "availabilityStatuses"

export const useAvailabilityStatusesStore = defineStore(storeName, {
    state: (): { _entities: Array<AvailabilityStatus> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<AvailabilityStatus> => state._entities,
        formattedName: function () {
            return (id: number | null): string => {
                if (id == null) {
                    return ""
                }

                let entity: AvailabilityStatus | undefined = this.entities.find(
                    (e: AvailabilityStatus) => e.id === id
                )
                if (!entity) {
                    return ""
                }

                return entity.formatted_short_name
            }
        },
        options: function (): Array<Option> {
            return this.entities.map(
                (availabilityStatus: AvailabilityStatus): Option => ({
                    value: availabilityStatus.id,
                    label: availabilityStatus.name,
                    disabled: false,
                })
            )
        },
        optionsFormatted: function (): Array<Option> {
            return this.entities.map(
                (availabilityStatus: AvailabilityStatus): Option => ({
                    value: availabilityStatus.id,
                    label: availabilityStatus.formatted_short_name,
                    disabled: false,
                })
            )
        },
    },
    actions: {
        setEntities(entities: Array<AvailabilityStatus>): void {
            this._entities = entities
        },
    },
})
