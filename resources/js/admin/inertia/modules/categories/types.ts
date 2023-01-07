import { Seo } from "@/admin/inertia/modules/common/types"

export interface CategoriesTreeItem {
    id: number
    uuid: string
    name: string
    subcategories: Array<CategoriesTreeItem>
}

export interface CategoryListItem {
    id: number
    uuid: string
    name: string | null
    ordering: number | null
    is_active: boolean | null
    product_type: number
}

export interface Category {
    id: number
    uuid: string
    name: string | null
    slug: string | null
    is_active: boolean | null
    product_type: number
    ordering: number | null
    description: string | null
    parent_id: number | null
    seo: Seo | null
    products: Array<CategoryProduct>
}

interface CategoryProduct {
    id: number
    uuid: string
    name: string | null
    is_active: boolean | null
}
