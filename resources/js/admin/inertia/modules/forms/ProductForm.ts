export interface ProductForm {
    id?: number
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
    mainImage?: MainImage
    additionalImages?: Array<AdditionalImage>
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

interface MainImage {
    id: number | null
    url: string | null
    name: string | null
    file_name: string | null
    file: File | null
}

export interface AdditionalImage {
    id: number | null
    url: string | null
    name: string | null
    file_name: string | null
    order_column: number | null
    file: File | null
}

export interface CharCategory {
    id: number | string
    uuid: string
    name: string | null
    product_id: number | null
    ordering: number
}

export interface Char {
    id: number | null
    uuid: string
    name: string | null
    value: string | number | null
    product_id: number | null
    type_id: number
    is_rate: boolean
    category_id: number | string
    category_uuid: string
    ordering: number
}
