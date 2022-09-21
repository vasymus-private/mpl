import { defineStore } from "pinia"
import {
    Currency,
    CharCode,
    Rate, CurrencyName,
} from "@/admin/inertia/modules/currencies/types"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "currencies"

interface State {
    _entities: Array<Currency>
    _rates: Array<Rate>
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
        entity:
            (state: State) =>
            (currencyIdOrName: CurrencyName | number | null): Currency | null =>
                state._entities.find(
                    (item: Currency): boolean => item.id === currencyIdOrName || item.name === currencyIdOrName
                ),
        rates: (state: State): Array<Rate> => state._rates,
        rate: function () {
            return (currencyName: CurrencyName): Rate|undefined => this.rates.find(
                (r) => r.CharCode === currencyName
            )
        },
        priceFormatted: function () {
            return (
                price: number | null,
                currencyId: number | null
            ): string => {
                if (price == null) {
                    return ""
                }
                if (currencyId == null) {
                    return ""
                }

                let currency: Currency | undefined = this.entity(currencyId)
                if (!currency) {
                    return ""
                }

                return new Intl.NumberFormat("ru-RU", {
                    style: "currency",
                    currency: currency.name,
                }).format(price)
            }
        },
        convertedToRub: function() {
            return (
                value: number,
                fromCurrency: Currency
            ): number | null => {
                if (fromCurrency.name === CharCode.RUB) {
                    return value
                }

                let rate: Rate | undefined = this.rate(fromCurrency.name)
                if (!rate) {
                    return null
                }

                let multiplier = rate.Value / rate.Nominal

                return value * multiplier
            }
        },
        priceRubFormatted: function () {
            return (
                price: number | null,
                currencyIdOrName: CurrencyName | number | null
            ): string => {
                if (price == null) {
                    return ""
                }
                if (currencyIdOrName == null) {
                    return ""
                }

                let currency: Currency | undefined = this.entity(currencyIdOrName)
                if (!currency) {
                    return ""
                }

                let rub = this.convertedToRub(price, currency)

                return new Intl.NumberFormat("ru-RU", {
                    style: "currency",
                    currency: "RUB",
                }).format(rub)
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
    },
})
