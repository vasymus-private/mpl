export interface ProductForm {
    is_active?: boolean
    name?: string
    slug?: string
    ordering?: number
    brand_id?: number
    coefficient?: number
    coefficient_description?: string
    coefficient_description_show?: boolean
    coefficient_variation_description?: string
    price_name?: string
    infoPrices?: Array<InfoPrice>
    admin_comment?: string
    instructions?: Array<Instruction>
    price_purchase?: number
    price_purchase_currency_id?: number
    price_retail?: number
    price_retail_currency_id?: number
    unit?: string
    availability_status_id?: number
    preview?: string
    description?: string
}

interface InfoPrice {
    id?: number
    name?: string
    price?: number
}

export interface Instruction {
    id: number | null
    url: string | null
    name: string | null
    file_name: string | null
    order_column: number | null
    file: File | null
}
