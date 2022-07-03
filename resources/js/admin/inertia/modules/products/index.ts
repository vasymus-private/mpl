import { defineStore } from "pinia"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"

export const storeName = "products"

export const useProductsStore = defineStore(storeName, {
    state: (): { _productListItems: Array<ProductListItem> } => {
        return {
            _productListItems: [],
        }
    },
    getters: {
        productListItems: (state): Array<ProductListItem> =>
            state._productListItems,
    },
    actions: {
        setProductListItems(productListItems: Array<ProductListItem>): void {
            this._productListItems = productListItems
        },
    },
})

export const getActiveName = (is_active: boolean|null) => is_active ? 'Да' : 'Нет'
