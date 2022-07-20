import { defineStore } from "pinia"
import Currency from "@/admin/inertia/modules/currencies/Currency"
import Option from "@/admin/inertia/modules/common/Option";

export const storeName = "currencies"

export const useCurrenciesStore = defineStore(storeName, {
    state: (): { _entities: Array<Currency> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<Currency> => state._entities,
        options: function (): Array<Option> {
            return this.entities.map((currency: Currency): Option => ({value: currency.id, label: currency.name, disabled: false}))
        },
    },
    actions: {
        setEntities(entities: Array<Currency>): void {
            this._entities = entities
        },
    },
})
