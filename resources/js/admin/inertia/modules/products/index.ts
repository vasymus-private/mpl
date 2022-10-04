import { defineStore } from "pinia"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import Option from "@/admin/inertia/modules/common/Option"
import {
    errorsToErrorFields,
    extendMetaLinksWithComputedData,
} from "@/admin/inertia/modules/common"
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
    SearchType,
} from "@/admin/inertia/modules/products/Product"
import axios, { AxiosError } from "axios"
import { arrayToMap } from "@/admin/inertia/utils"
import { ErrorResponse, UrlParams } from "@/admin/inertia/modules/common/types"

export const storeName = "products"

export const additionalOrderProduct = "additionalOrderProduct"

interface State {
    _productListItems: Array<ProductListItem>
    _links: Links | null
    _meta: Meta | null
    _product: { entity: Product | null; loading: boolean }
    _searchProduct: Partial<
        Record<
            SearchType,
            {
                entities: Array<SearchProduct>
                meta: Meta | null
                loading: boolean
            }
        >
    >
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
                [additionalOrderProduct]: {
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
            if (!this.isCreatingProductRoute) {
                return false
            }

            const routesStore = useRoutesStore()

            return routesStore.hasUrlParam(UrlParams.copy_id)
        },
        searchProducts:
            (state: State) =>
            (type: SearchType): Array<SearchProduct> =>
                state._searchProduct[type].entities,
        searchProductsLoading:
            (state: State) =>
            (type: SearchType): boolean =>
                state._searchProduct[type].loading,
        additionalOrderProductSearch(): Array<SearchProduct> {
            return this.searchProducts(additionalOrderProduct)
        },
        additionalOrderProductSearchLoading(): boolean {
            return this.searchProductsLoading(additionalOrderProduct)
        },
        additionalOrderProductSearchMeta(state: State): Meta | null {
            return state._searchProduct[additionalOrderProduct].meta
        },
        additionalOrderProductSearchPerPage(): Option | null {
            return this.additionalOrderProductSearchMeta &&
                this.additionalOrderProductSearchMeta.per_page
                ? {
                      value: this.additionalOrderProductSearchMeta.per_page,
                      label: `${this.additionalOrderProductSearchMeta.per_page}`,
                  }
                : null
        },
    },
    actions: {
        setProductListItems(productListItems: Array<ProductListItem>): void {
            this._productListItems = productListItems
        },
        removeProductListItems(ids: Array<number>): void {
            this._productListItems = this._productListItems.filter(
                (item) => !ids.includes(item.id)
            )
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
        async fetchSearchProducts(
            request: SearchProductRequest,
            type: SearchType
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

                this.setSearchProductEntities(products, type)
                this.setSearchProductsMeta(meta, type)
            } finally {
                this._searchProduct[type].loading = false
            }
        },
        setSearchProductEntities(
            products: Array<SearchProduct>,
            type: SearchType
        ): void {
            switch (type) {
                case additionalOrderProduct: {
                    this._searchProduct[additionalOrderProduct].entities =
                        products.map((item) => ({ ...item, _is_open: false }))
                    break
                }
                default: {
                    this._searchProduct[type].entities = products
                    break
                }
            }
        },
        setSearchProductsMeta(meta: Meta | null, type: SearchType): void {
            this._searchProduct[type].meta = meta
                ? extendMetaLinksWithComputedData(meta)
                : null
        },
        async fetchAdditionalOrderProduct(
            request: SearchProductRequest
        ): Promise<void> {
            await this.fetchSearchProducts(request, additionalOrderProduct)
        },
        toggleAdditionalOrderProductItemOpen(item: SearchProduct): void {
            this._searchProduct[additionalOrderProduct].entities.forEach(
                (it: SearchProduct) => {
                    if (it.uuid === item.uuid) {
                        it._is_open = !it._is_open
                    }
                }
            )
        },
        async deleteBulkProducts(
            ids: Array<number>
        ): Promise<void | Record<string, string | undefined>> {
            if (!ids.length) {
                return
            }

            const routesStore = useRoutesStore()
            const productsStore = useProductsStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_PRODUCTS_BULK_DELETE
                    )
                )
                ids.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                productsStore.removeProductListItems(ids)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    return errorsToErrorFields(errors)
                }
                throw e
            }
        },
    },
})
