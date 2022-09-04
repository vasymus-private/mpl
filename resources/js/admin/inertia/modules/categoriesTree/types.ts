import {Seo} from "@/admin/inertia/modules/common/types"

export interface CategoriesTreeItem {
    id: number
    name: string
    subcategories: Array<CategoriesTreeItem>
}

export interface CategoryListItem {
    id: number
    name: string|null
    ordering: number|null
    is_active: boolean|null
}

export interface Category {
    id: number
    name: string|null
    slug: string|null
    is_active: boolean|null
    ordering: number|null
    description: string|null
    parent_id: number|null
    seo: Seo|null
    products: Array<CategoryProduct>
}

interface CategoryProduct {
    id: number
    name: string|null
    is_active: boolean|null
}
