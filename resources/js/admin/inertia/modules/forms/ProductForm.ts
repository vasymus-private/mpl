import Image from "@/admin/inertia/modules/common/Image"

export interface ProductForm {
    id?: number
    uuid?: string
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
    mainImage?: Image
    additionalImages?: Array<Image>
    seo?: Seo
    category_id?: number
    relatedCategoriesIds?: Array<number>
    accessories?: Array<OtherProduct>
    similar?: Array<OtherProduct>
    related?: Array<OtherProduct>
    works?: Array<OtherProduct>
    instruments?: Array<OtherProduct>
    variations?: Array<Variation>
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

interface Seo {
    title: string | null
    h1: string | null
    keywords: string | null
    description: string | null
}

interface OtherProduct {
    id: number
    uuid: string
    name: string
    image: string | null
    price_rub_formatted: string | null
}

export interface Variation {
    id: number | null
    uuid: string | null
    is_active: boolean
    name: string | null
    ordering: number | null
    coefficient: number | null
    coefficient_description: string | null
    unit: string | null
    availability_status_id?: number
    price_purchase: number | null
    price_purchase_currency_id: number | null
    price_retail: number | null
    price_retail_currency_id: number | null
    preview: string | null
    mainImage: Image | null
    additionalImages: Array<Image>
}
