import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import {Errors} from "@/admin/inertia/modules/common/types";

export interface ProductsResponse {
    data: Array<ProductListItem>
}
export interface Values {
    products: Array<Partial<ProductListItem>>
}


export interface ErrorResponse {
    data: {
        errors: Errors
    }
}
