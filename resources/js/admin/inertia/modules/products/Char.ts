export interface CharCategory {
    id: number
    uuid?: string | null
    name: string
    product_id: number
    ordering: number
    chars: Array<Char>
}

export interface Char {
    id: number
    uuid?: string | null
    name: string
    value: string | number | null
    product_id: number
    type_id: number
    is_rate?: boolean
    category_id: number
    category_uuid?: string | null
    ordering: number
}
