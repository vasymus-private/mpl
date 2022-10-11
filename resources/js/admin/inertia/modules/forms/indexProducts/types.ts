import {ProductListItem} from "@/admin/inertia/modules/products/types"

export interface Values {
    products: Array<Partial<ProductListItem>>
}
export interface ProductsResponse {
    data: Array<ProductListItem>
}
