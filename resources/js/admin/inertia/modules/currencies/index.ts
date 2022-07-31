import { defineStore } from "pinia"
import Currency, {CHAR_CODE_RUB, Rate} from "@/admin/inertia/modules/currencies/Currency"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "currencies"

interface State {
    _entities: Array<Currency>,
    _rates: Array<Rate>,
}

export const useCurrenciesStore = defineStore(storeName, {
    state: (): State => {
        return {
            _entities: [],
            _rates: [],
        }
    },
    getters: {
        entities: (state: State): Array<Currency> => state._entities,
        entity: (state: State) => (id: number|null): Currency|null => state._entities.find((item: Currency): boolean => item.id === id),
        rates: (state: State): Array<Rate> => state._rates,
        priceFormatted: function() {
            return (price: number|null, currencyId: number|null): string => {
                if (price == null) {
                    return ''
                }
                if (currencyId == null) {
                    return ''
                }

                let currency: Currency|undefined = this.entity(currencyId)
                if (!currency) {
                    return ''
                }

                return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: currency.name }).format(price)
            }
        },
        priceRubFormatted: function() {
            return (price: number|null, currencyId: number|null): string => {
                if (price == null) {
                    return ''
                }
                if (currencyId == null) {
                    return ''
                }

                let currency: Currency|undefined = this.entity(currencyId)
                if (!currency) {
                    return ''
                }

                let rub = this.convertToRub(price, currency)

                return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(rub)
            }
        },

        options: function (): Array<Option> {
            return this.entities.map(
                (currency: Currency): Option => ({
                    value: currency.id,
                    label: currency.name,
                    disabled: false,
                })
            )
        },
    },
    actions: {
        setEntities(entities: Array<Currency>): void {
            this._entities = entities
        },
        setRates(rates: Array<Rate>): void {
            this._rates = rates
        },
        convertToRub: function(value: number, fromCurrency: Currency): number|null {
            if (fromCurrency.name === CHAR_CODE_RUB) {
                return value
            }

            let rate: Rate|undefined = this.rates.find(r => r.CharCode === fromCurrency.name)
            if (!rate) {
                return null
            }

            let multiplier = rate.Value / rate.Nominal

            return value * multiplier
        },
    },
})
