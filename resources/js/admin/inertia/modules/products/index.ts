import { defineStore } from "pinia"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import Option from "@/admin/inertia/modules/common/Option"
import { extendMetaLinksWithComputedData } from "@/admin/inertia/modules/common"
import {
    getRouteUrl,
    routeNames,
    useRoutesStore,
} from "@/admin/inertia/modules/routes"
import Product, {
    ProductProductType,
    SearchProduct,
    SearchProductRequest,
    searchProductRequestToUrlSearchParams,
    SearchProductResponse,
} from "@/admin/inertia/modules/products/Product"
import axios from "axios"
import { arrayToMap } from "@/admin/inertia/utils"

export const storeName = "products"

interface State {
    _productListItems: Array<ProductListItem>
    _links: Links | null
    _meta: Meta | null
    _product: { entity: Product | null; loading: boolean }
    _searchProduct: {
        [key in ProductProductType]: {
            entities: Array<SearchProduct>
            meta: Meta | null
            loading: boolean
        }
    }
}

export const useProductsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _productListItems: [],
            _links: null,
            _meta: null,
            _product: { entity: null, loading: false },
            _searchProduct: {
                [ProductProductType.TYPE_ACCESSORY]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_SIMILAR]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_RELATED]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_WORK]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_INSTRUMENT]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
            },
        }
    },
    getters: {
        productListItems: (state: State): Array<ProductListItem> =>
            state._productListItems,
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
        product: (state: State): Product | null => state._product.entity,
        isCreatingProductRoute() {
            let routesStore = useRoutesStore()

            return [
                routeNames.ROUTE_ADMIN_PRODUCTS_CREATE,
                routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE,
            ].includes(routesStore.current)
        },
        isCreatingFromCopy(): boolean {
            let isCreating = this.isCreatingProductRoute
            if (!isCreating) {
                return false
            }

            const routesStore = useRoutesStore()
            if (!routesStore.fullUrl) {
                return false
            }

            return !!new URL(routesStore.fullUrl).searchParams.get("copy_id")
        },
        searchProducts:
            (state: State) =>
            (type: ProductProductType): Array<SearchProduct> =>
                state._searchProduct[type].entities,
        searchProductsLoading:
            (state: State) =>
            (type: ProductProductType): boolean =>
                state._searchProduct[type].loading,
    },
    actions: {
        setProductListItems(productListItems: Array<ProductListItem>): void {
            this._productListItems = productListItems
        },
        addOrUpdateProductListItems(
            productListItems: Array<ProductListItem>
        ): void {
            let newProductListItemsById =
                arrayToMap<ProductListItem>(productListItems)

            this._productListItems = this._productListItems.map(
                (item: ProductListItem) => {
                    let newProductListItem = newProductListItemsById[item.id]

                    if (newProductListItem) {
                        productListItems = productListItems.filter(
                            (it) => it.id !== item.id
                        )
                        return newProductListItem
                    }

                    return item
                }
            )

            this._productListItems = [
                ...this._productListItems,
                ...productListItems,
            ]
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
        setProduct(product: Product | null): void {
            this._product.entity = product
        },
        async handleDelete(selected: Array<number>): Promise<void> {
            console.log("---", selected)
        },
        async fetchSearchProducts(
            request: SearchProductRequest,
            type: ProductProductType
        ): Promise<void> {
            try {
                this._searchProduct[type].loading = true

                let url = new URL(
                    getRouteUrl(routeNames.ROUTE_ADMIN_AJAX_PRODUCT_SEARCH)
                )
                url.search =
                    searchProductRequestToUrlSearchParams(request).toString()
                const {
                    data: { data: products, meta },
                } = await axios.get<SearchProductResponse>(url.toString())

                this._searchProduct[type].entities = products
                this._searchProduct[type].meta = meta
            } finally {
                this._searchProduct[type].loading = false
            }
        },
    },
})

export const getPerPageOptions = (): Array<Option> =>
    [5, 10, 20, 50, 100, 200, 500].map((page) => ({
        value: page,
        label: `${page}`,
    }))
