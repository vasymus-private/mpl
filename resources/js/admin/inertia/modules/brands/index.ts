import { defineStore } from "pinia"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "brands"

export const useBrandsStore = defineStore(storeName, {
    state: (): { _options: Array<Option> } => {
        return {
            _options: [],
        }
    },
    getters: {
        options: (state): Array<Option> => state._options,
    },
    actions: {
        setOptions(options: Array<Option>): void {
            this._options = options
        },
    },
})
