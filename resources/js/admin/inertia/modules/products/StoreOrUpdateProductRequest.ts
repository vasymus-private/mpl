export default interface StoreOrUpdateProductRequest {
    name?: string | null
    slug?: string | null
    ordering?: number | null
    is_active?: boolean | null
    unit?: string | null
    price_purchase?: number | null
    price_purchase_currency_id?: number | null
    price_retail?: number | null
    price_retail_currency_id?: number | null
    admin_comment?: string | null
    availability_status_id?: number | null
    parent_id?: number | null
    brand_id?: number | null
    category_id?: number | null
    is_with_variations?: boolean | null
    coefficient?: number | null
    coefficient_description?: string | null
    coefficient_description_show?: boolean | null
    coefficient_variation_description?: string | null
    price_name?: string | null
    preview?: string | null
    description?: string | null
    accessory_name?: string | null
    similar_name?: string | null
    related_name?: string | null
    work_name?: string | null
    instruments_name?: string | null
    seo?: SeoRequest | null
}

export interface SeoRequest {
    title?: string | null
    h1?: string | null
    keywords?: string | null
    description?: string | null
}
