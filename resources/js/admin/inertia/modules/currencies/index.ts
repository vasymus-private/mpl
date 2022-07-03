import { defineStore } from "pinia"
import Currency from "@/admin/inertia/modules/currencies/Currency"

export const storeName = "currencies"

export const useCurrenciesStore = defineStore(storeName, {
    state: (): { _entities: Array<Currency> } => {
        return {
            _entities: [],
        }
    },
    getters: {
        entities: (state): Array<Currency> => state._entities,
    },
    actions: {
        setEntities(entities: Array<Currency>): void {
            this._entities = entities
        },
    },
})
