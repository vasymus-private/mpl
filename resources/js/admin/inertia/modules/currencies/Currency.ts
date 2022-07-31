export default interface Currency {
    id: number
    name: string
}

export interface Rate {
    NumCode: number
    CharCode: string
    Nominal: number
    Name: string
    ValueRaw: string
    Value: number
}

export const CHAR_CODE_RUB = 'RUB'
