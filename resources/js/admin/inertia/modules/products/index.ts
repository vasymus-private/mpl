import {defineStore} from "pinia"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import Option from "@/admin/inertia/modules/common/Option"
import {extendMetaLinksWithComputedData} from "@/admin/inertia/modules/common"
import {getRouter, getRouteUrl, routeNames, useRoutesStore,} from "@/admin/inertia/modules/routes"
import Product from "@/admin/inertia/modules/products/Product"
import StoreOrUpdateProductRequest from "@/admin/inertia/modules/products/StoreOrUpdateProductRequest"
import axios from "axios"
import ProductUpdateResponse, {ProductUpdate,} from "@/admin/inertia/modules/products/ProductUpdateResponse"
import {AdminTab, TabEnum} from "@/admin/inertia/modules/products/Tabs";

export const storeName = "products"

export const useProductsStore = defineStore(storeName, {
    state: (): {
        _productListItems: Array<ProductListItem>
        _links: Links | null
        _meta: Meta | null
        _product: { entity: Product | null; loading: boolean }
        _originProduct: Product | null
    } => {
        return {
            _productListItems: [],
            _links: null,
            _meta: null,
            _product: { entity: null, loading: false },
            _originProduct: null,
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
        product: (state): Product | null => state._product.entity,
        originProduct: (state): Product | null => state._originProduct,
        isCreatingFromCopy(): boolean {
            const routesStore = useRoutesStore()
            if (!routesStore.fullUrl) {
                return false
            }

            return (
                !!new URL(routesStore.fullUrl).searchParams.get("copy_id") &&
                isCreatingProductRoute() &&
                !!this.originProduct
            )
        },
        getAllAdminTabs: (): Array<AdminTab> => {
            return [
                {
                    value: TabEnum.elements,
                    label : 'Элемент',
                },
                {
                    value: TabEnum.description,
                    label: 'Описание',
                },
                {
                    value: TabEnum.photo,
                    label: 'Фото',
                },
                {
                    value: TabEnum.characteristics,
                    label: 'Характеристики',
                },
                {
                    value: TabEnum.seo,
                    label: 'SEO',
                },
                {
                    value: TabEnum.accessories,
                    label: 'Аксессуары',
                },
                {
                    value: TabEnum.similar,
                    label: 'Похожие',
                },
                {
                    value: TabEnum.related,
                    label: 'Сопряжённые',
                },
                {
                    value: TabEnum.works,
                    label: 'Работы',
                },
                {
                    value: TabEnum.instruments,
                    label: 'Инструменты',
                },
                {
                    value: TabEnum.variations,
                    label: 'Варианты',
                },
                {
                    value: TabEnum.other,
                    label: 'Прочее',
                }
            ]
        },
        getAdminTabs(state): Array<AdminTab> {
            if (state._product?.entity?.is_with_variations) {
                return this.getAllAdminTabs
            }

            return this.getAllAdminTabs.filter((tab: AdminTab) => tab.value !== TabEnum.variations)
        },
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
        setProduct(product: Product | null): void {
            this._product.entity = product
        },
        updateProduct(update: ProductUpdate): void {
            for (let key in update) {
                this._product.entity[key] = update[key]
                console.log(key, this._product.entity, this._product.entity[key], update[key])
            }
        },
        setOriginProduct(product: Product | null): void {
            this._originProduct = product
        },
        async handleCreate(
            productRequest: StoreOrUpdateProductRequest
        ): Promise<void> {},
        async handleUpdate(
            productRequest: StoreOrUpdateProductRequest
        ): Promise<void> {
            this._product.loading = true
            try {
                const { data: {data: productUpdate} } =
                    await axios.put<ProductUpdateResponse>(
                        getRouteUrl(
                            routeNames.ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE,
                            {admin_product: this._product.entity.id}
                        ),
                        productRequest
                    )

                this.updateProduct(productUpdate)
            } catch (e) {
                console.warn(e)
            } finally {
                this._product.loading = false
            }
        },
        async handleDelete(selected: Array<number>): Promise<void> {
            console.log("---", selected)
        },
    },
})

export const getActiveName = (is_active: boolean | null) =>
    is_active ? "Да" : "Нет"

export const getPerPageOptions = (): Array<Option> =>
    [5, 10, 20, 50, 100, 200, 500].map((page) => ({
        value: page,
        label: `${page}`,
    }))

export const isCreatingProductRoute = (): boolean => {
    const router = getRouter()

    return [
        routeNames.ROUTE_ADMIN_PRODUCTS_CREATE,
        routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE,
    ].includes(router.current())
}
