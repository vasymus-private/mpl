import { defineStore } from "pinia"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import Option from "@/admin/inertia/modules/common/Option"
import { extendMetaLinksWithComputedData } from "@/admin/inertia/modules/common"
import { useRoutesStore } from "@/admin/inertia/modules/routes"

export const storeName = "products"

export const useProductsStore = defineStore(storeName, {
    state: (): {
        _productListItems: Array<ProductListItem>
        _links: Links | null
        _meta: Meta | null
    } => {
        return {
            _productListItems: [],
            _links: null,
            _meta: null,
        }
    },
    getters: {
        productListItems: (state): Array<ProductListItem> =>
            state._productListItems,
        links: (state): Links | null => state._links,
        meta: (state): Meta | null => state._meta,
        getPerPageOption: (state): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
    },
    actions: {
        setProductListItems(productListItems: Array<ProductListItem>): void {
            this._productListItems = productListItems
        },
        setLinks(links: Links | null): void {
            this._links = links
        },
        setMeta(meta: Meta | null): void {
            const routesStore = useRoutesStore()
            this._meta = meta
                ? extendMetaLinksWithComputedData(meta, routesStore.fullUrl)
                : null
        },
        async handleDelete(selected: Array<number>): Promise<void> {
            console.log('---', selected)
        }
    },
})

export const getActiveName = (is_active: boolean | null) =>
    is_active ? "Да" : "Нет"

export const getPerPageOptions = (): Array<Option> =>
    [5, 10, 20, 50, 100, 200, 500].map((page) => ({
        value: page,
        label: `${page}`,
    }))
