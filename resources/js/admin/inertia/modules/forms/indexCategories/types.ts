import { CategoryListItem } from "@/admin/inertia/modules/categories/types"

export interface Values {
    categories: Array<Partial<CategoryListItem>>
}
export interface CategoriesResponse {
    data: Array<CategoryListItem>
}
