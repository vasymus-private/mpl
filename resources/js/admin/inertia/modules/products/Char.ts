export interface CharCategory {
    id: number
    name: string
    product_id: number
    ordering: number
    chars: Array<Char>
}

export interface Char {
    id: number
    name: string
    value: string | number | null
    product_id: number
    type_id: number
    category_id: number
    ordering: number
}
