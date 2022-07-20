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
}

interface InfoPrice {
    id?: number
    name?: string
    price?: number
}
