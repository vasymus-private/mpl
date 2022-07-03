import { defineStore } from "pinia"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import Links from "@/admin/inertia/modules/common/Links";
import Meta from "@/admin/inertia/modules/common/Meta";

export const storeName = "products"

export const useProductsStore = defineStore(storeName, {
    state: (): { _productListItems: Array<ProductListItem>, _links: Links|null, _meta: Meta|null } => {
        return {
            _productListItems: [],
            _links: null,
            _meta: null,
        }
    },
    getters: {
        productListItems: (state): Array<ProductListItem> =>
            state._productListItems,
        links: (state): Links|null => state._links,
        meta: (state): Meta|null => state._meta,
    },
    actions: {
        setProductListItems(productListItems: Array<ProductListItem>): void {
            this._productListItems = productListItems
        },
        setLinks(links: Links|null): void {
            this._links = links
        },
        setMeta(meta: Meta|null): void {
            this._meta = meta
        }
    },
})

export const getActiveName = (is_active: boolean|null) => is_active ? 'Да' : 'Нет'
