import { defineStore } from "pinia"
import CharType from "@/admin/inertia/modules/charTypes/CharType"

export const storeName = "charTypes"

export const useCharTypesStore = defineStore(storeName, {
    state: (): { _entities: Array<CharType> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        options: (state): Array<CharType> => state._entities,
    },
    actions: {
        setChartTypes(types: Array<CharType>): void {
            this._entities = types
        },
    },
})
