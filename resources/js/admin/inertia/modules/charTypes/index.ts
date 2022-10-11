import { defineStore } from "pinia"
import { CharType } from "@/admin/inertia/modules/charTypes/types"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "charTypes"

export const useCharTypesStore = defineStore(storeName, {
    state: (): { _entities: Array<CharType> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        options: (state): Array<Option> =>
            state._entities.map((item: CharType) => ({
                value: item.id,
                label: item.name,
            })),
    },
    actions: {
        setChartTypes(types: Array<CharType>): void {
            this._entities = types
        },
    },
})
