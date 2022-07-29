import { defineStore } from "pinia"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "brands"

interface State {
    _options: Array<Option>
}

export const useBrandsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _options: [],
        }
    },
    getters: {
        options: (state: State): Array<Option> => state._options,
    },
    actions: {
        setOptions(options: Array<Option>): void {
            this._options = options
        },
    },
})
