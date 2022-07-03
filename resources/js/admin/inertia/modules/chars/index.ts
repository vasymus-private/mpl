import { defineStore } from "pinia"
import CharType from "@/admin/inertia/modules/chars/CharType"

export const storeName = "chars"

export const useCharsStore = defineStore(storeName, {
    state: (): { _types: Array<CharType> } => {
        return {
            _types: [],
        }
    },
    getters: {
        types: (state): Array<CharType> => state._types,
    },
    actions: {
        setChartTypes(types: Array<CharType>): void {
            this._types = types
        },
    },
})
