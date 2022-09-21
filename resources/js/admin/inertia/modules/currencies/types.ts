export type CurrencyName = CharCode | string

export interface Rate {
    NumCode: number
    CharCode: CurrencyName
    Nominal: number
    Name: string
    ValueRaw: string
    Value: number
}

export enum CharCode {
    EUR = 'EUR',
    USD = 'USD',
    RUB = 'RUB'
}

export interface Currency {
    id: number
    name: CurrencyName
}
