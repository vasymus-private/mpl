import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"

export interface ProductsResponse {
    data: Array<ProductListItem>
}
export interface Values {
    products: Array<Partial<ProductListItem>>
}
export interface Errors {
    [key: string]: Array<string>
}

export interface ErrorResponse {
    data: {
        errors: Errors
    }
}
