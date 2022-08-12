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
        nullableOptions(): Array<Option> {
            return [
                {
                    value: null,
                    label: 'Производитель',
                },
                ...this.options,
            ]
        },
        option() {
            return (brandId: string|number): Option|null => {
                let option = this.options.find((o:Option) => `${o.value}` === `${brandId}`)
                return option ? option : null
            }
        }
    },
    actions: {
        setOptions(options: Array<Option>): void {
            this._options = options
        },
    },
})
