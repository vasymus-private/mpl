import { CharCategory } from "@/admin/inertia/modules/products/Char"
import Meta from "@/admin/inertia/modules/common/Meta"
import Media from "@/admin/inertia/modules/common/Media"
import { Seo } from "@/admin/inertia/modules/common/types"

export default interface Product {
    id: number | null
    uuid: string | null
    name: string | null
    slug: string | null
    ordering: number | null
    is_active: boolean | null
    unit: string | null
    price_purchase: number | null
    price_purchase_currency_id: number | null
    price_retail: number | null
    price_retail_currency_id: number | null
    admin_comment: string | null
    availability_status_id: number | null
    parent_id: number | null
    brand_id: number | null
    category_id: number | null
    relatedCategoriesIds: Array<number>
    is_with_variations: boolean | null
    coefficient: number | null
    coefficient_description: string | null
    coefficient_description_show: boolean | null
    coefficient_variation_description: string | null
    price_name: string | null
    preview: string | null
    description: string | null
    accessory_name: string | null
    similar_name: string | null
    related_name: string | null
    work_name: string | null
    instruments_name: string | null
    web_route: string | null
    seo: Seo | null
    infoPrices: Array<InfoPrice> | null
    instructions: Array<Media>
    mainImage: Media | null
    additionalImages: Array<Media>
    charCategories: Array<CharCategory>
    accessories: Array<OtherProduct>
    similar: Array<OtherProduct>
    related: Array<OtherProduct>
    works: Array<OtherProduct>
    instruments: Array<OtherProduct>
    variations: Array<Variation>
}

export interface InfoPrice {
    id: number | null
    name: string | null
    price: number | null
    product_id: number | null
}

interface OtherProduct {
    id: number
    uuid: string
    name: string
    image: string | null
    price_rub_formatted: string | null
}

export type SearchType = ProductProductType | string

export enum ProductProductType {
    TYPE_ACCESSORY = 1,
    TYPE_SIMILAR = 2,
    TYPE_RELATED = 3,
    TYPE_WORK = 4,
    TYPE_INSTRUMENT = 5,
}

export interface SearchProductRequest {
    category_ids?: Array<number | string> | null
    search?: string | null
    page?: number | null
    per_page?: number | null
    brand_id?: number | null
}

export const searchProductRequestToUrlSearchParams = (
    request: SearchProductRequest
): URLSearchParams => {
    const res = new URLSearchParams()
    if (request.category_ids) {
        request.category_ids.forEach((item: number | string) =>
            res.append("category_ids[]", `${item}`)
        )
    }
    if (request.search) {
        res.append("search", request.search)
    }
    if (request.page) {
        res.append("page", `${request.page}`)
    }
    if (request.per_page) {
        res.append("per_page", `${request.per_page}`)
    }

    if (request.brand_id) {
        res.append("brand_id", `${request.brand_id}`)
    }

    return res
}

export interface SearchProduct {
    id: number
    uuid: string
    is_active: boolean
    name: string
    image: string | null
    price_rub_formatted: string | null
    is_with_variations: boolean
    unit: string | null
    price_purchase: number | null
    price_purchase_currency_id: number | null
    price_retail: number | null
    price_retail_currency_id: number | null
    ordering: number | null
    _is_open?: boolean
    variations: Array<SearchProductVariation>
}
export interface SearchProductVariation {
    id: number
    uuid: string
    is_active: boolean
    name: string
    image: string | null
    price_rub_formatted: string | null
    is_with_variations: boolean
    unit: string | null
    price_purchase: number | null
    price_purchase_currency_id: number | null
    price_retail: number | null
    price_retail_currency_id: number | null
    ordering: number | null
}

export interface SearchProductResponse {
    data: Array<SearchProduct>
    meta: Meta
}

export interface Variation {
    id: number | null
    uuid: string | null
    name: string | null
    is_active: boolean | null
    ordering: number | null
    coefficient: number | null
    coefficient_description: string | null
    unit: string | null
    availability_status_id: number | null
    price_purchase: number | null
    price_purchase_currency_id: number | null
    price_retail: number | null
    price_retail_currency_id: number | null
    preview: string | null
    mainImage: Media | null
    additionalImages: Array<Media>
}
