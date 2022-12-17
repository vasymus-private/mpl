import { defineStore } from "pinia"
import { useCategoriesStore } from "@/admin/inertia/modules/categories"
import route, {
    Config,
    RouteParam,
    RouteParamsWithQueryOverload,
    Router,
} from "ziggy-js"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import * as H from "history"
import {
    UrlParams,
    AdminTab,
    TabEnum,
    Option,
} from "@/admin/inertia/modules/common/types"
import { getAmendedZiggyConfig, isNumeric } from "@/admin/inertia/utils"
import { usePage } from "@inertiajs/inertia-vue3"
import { InitialPageProps } from "@/admin/inertia/modules"

export const storeName = "routes"

export const useRoutesStore = defineStore(storeName, {
    state: (): { _fullUrl: string | null } => {
        return {
            _fullUrl: null,
        }
    },
    getters: {
        fullUrl: (state): string => {
            if (state._fullUrl) {
                return state._fullUrl
            }

            const pageProps = usePage<InitialPageProps>()
            return pageProps.props.value.fullUrl
        },
        url: function (): string | null {
            return this.fullUrl
                ? this.fullUrl
                : typeof location !== "undefined"
                ? location.href
                : null
        },
        urlParam: function () {
            return (key: string): string | number | boolean | null => {
                try {
                    let u = new URL(this.url)
                    let value = u.searchParams.get(key)

                    switch (true) {
                        case "true" === value: {
                            return true
                        }
                        case "false" === value: {
                            return false
                        }
                        case isNumeric(value): {
                            return +value
                        }
                        default: {
                            return value
                        }
                    }
                } catch (e) {
                    console.warn(e)
                    return null
                }
            }
        },
        activeTabUrlParam(): string | undefined {
            return this.urlParam(UrlParams.active_tab)
        },
        hasUrlParam: function () {
            return (key: string): boolean => {
                if (!this.url) {
                    return false
                }

                try {
                    let u = new URL(this.url)
                    return u.searchParams.has(key)
                } catch (e) {
                    console.warn(e)
                    return false
                }
            }
        },
        isActiveRoute() {
            return (
                type: RouteTypeEnum,
                id: number | string = null
            ): boolean => {
                const categoriesStore = useCategoriesStore()

                let router = this.router
                if (!router) {
                    return false
                }

                switch (type) {
                    case RouteTypeEnum.categoriesSub:
                    case RouteTypeEnum.categories: {
                        if (
                            !router.current(RouteNameGroupEnum.Products) &&
                            !router.current(RouteNameGroupEnum.Categories)
                        ) {
                            return false
                        }

                        if (id === null) {
                            return true
                        }

                        let categoryAndSubtreeIds =
                            categoriesStore.getCategoryAndSubtreeIds(id)

                        if (!categoryAndSubtreeIds) {
                            return false
                        }

                        let routeParams = router.params as {
                            [key: string]: RouteParam
                        }

                        let categoryIdParam =
                            +(routeParams.category_id as string)

                        return categoryAndSubtreeIds.includes(categoryIdParam)
                    }
                    case RouteTypeEnum.reference: {
                        return (
                            router.current(RouteNameGroupEnum.Brands) ||
                            router.current(RouteNameGroupEnum.Articles) ||
                            router.current(RouteNameGroupEnum.Services) ||
                            router.current(RouteNameGroupEnum.Faq) ||
                            router.current(RouteNameGroupEnum.Contacts)
                        )
                    }
                    case RouteTypeEnum.referenceBrands: {
                        return router.current(RouteNameGroupEnum.Brands)
                    }
                    case RouteTypeEnum.referenceArticles: {
                        return router.current(RouteNameGroupEnum.Articles)
                    }
                    case RouteTypeEnum.referenceServices: {
                        return router.current(RouteNameGroupEnum.Services)
                    }
                    case RouteTypeEnum.referenceFaq: {
                        return router.current(RouteNameGroupEnum.Faq)
                    }
                    case RouteTypeEnum.referenceContacts: {
                        return router.current(RouteNameGroupEnum.Contacts)
                    }
                    default: {
                        return false
                    }
                }
            }
        },
        productsUrlParamOptions(): Array<Option> {
            let categoriesStore = useCategoriesStore()
            let brandsStore = useBrandsStore()

            let categoryId = this.urlParam(UrlParams.category_id)
            let brandId = this.urlParam(UrlParams.brand_id)

            let result: Array<Option> = []

            if (categoryId != null) {
                let category = categoriesStore.option(`${categoryId}`)
                if (category) {
                    result = [
                        ...result,
                        {
                            ...category,
                            urlParam: UrlParams.category_id,
                        },
                    ]
                }
            }

            if (brandId != null) {
                let brand = brandsStore.option(`${brandId}`)
                if (brand) {
                    result = [
                        ...result,
                        {
                            ...brand,
                            urlParam: UrlParams.brand_id,
                        },
                    ]
                }
            }

            return result
        },
        categoriesUrlParamOptions(): Array<Option> {
            let categoryId = this.urlParam(UrlParams.category_id)

            let result: Array<Option> = []

            if (categoryId != null) {
                let categoriesStore = useCategoriesStore()
                let category = categoriesStore.option(`${categoryId}`)
                if (category) {
                    result = [
                        ...result,
                        {
                            ...category,
                            urlParam: UrlParams.category_id,
                        },
                    ]
                }
            }

            return result
        },
        route() {
            return (
                name: string,
                params?: RouteParamsWithQueryOverload | RouteParam
            ): string => {
                let u = new URL(this.fullUrl)
                let location = {
                    host: u.host,
                    pathname: u.pathname,
                    search: u.search,
                    state: typeof history !== "undefined" ? history.state : {},
                    hash: u.hash,
                } as H.Location

                let ziggyConfig = getAmendedZiggyConfig(this.fullUrl)

                let config = {
                    ...ziggyConfig,
                    location,
                } as Config

                return route(name, params, undefined, config)
            }
        },
        router(): Router {
            let u = new URL(this.fullUrl)
            let location = {
                host: u.host,
                pathname: u.pathname,
                search: u.search,
                state: typeof history !== "undefined" ? history.state : {},
                hash: u.hash,
            } as H.Location

            let ziggyConfig = getAmendedZiggyConfig(this.fullUrl)

            let config = {
                ...ziggyConfig,
                location,
            } as Config

            return route(undefined, undefined, undefined, config)
        },
        current(): string | null {
            return this.router ? this.router.current() : null
        },
        activeTab(): (tabs: Array<AdminTab>, def?: TabEnum) => string {
            return (tabs: Array<AdminTab>, def?: TabEnum): string => {
                let url = this.url
                if (!url) {
                    return def || TabEnum.elements
                }
                let paramActiveTab = new URL(url).searchParams.get(
                    UrlParams.active_tab
                )
                if (!paramActiveTab) {
                    return def || TabEnum.elements
                }

                if (
                    !tabs
                        .map((at) => at.value.toString())
                        .includes(paramActiveTab)
                ) {
                    return def || TabEnum.elements
                }

                return paramActiveTab
            }
        },
    },
    actions: {
        setFullUrl(fullUrl: string | null): void {
            this._fullUrl = fullUrl
        },
        replaceUrlParamState(
            key: UrlParams,
            value: string | number | boolean | null
        ): void {
            let u = new URL(this.url)
            let s = new URLSearchParams(u.search)

            switch (true) {
                case value == null: {
                    s.delete(key)
                    break
                }
                case typeof value === "boolean": {
                    s.set(key, value ? "true" : "false")
                    break
                }
                default: {
                    s.set(key, `${value}`)
                    break
                }
            }

            u.search = s.toString()
            history.replaceState(history.state, "", u.toString())
            this.setFullUrl(u.toString())
        },
    },
})

export const getRouteUrl = (
    name: string,
    params?: RouteParamsWithQueryOverload | RouteParam
): string => {
    let ziggyConfig = getAmendedZiggyConfig()

    return route(name, params, undefined, ziggyConfig as Config)
}

export const routeNames = {
    ROUTE_WEB_HOME: "home",
    ROUTE_LOGOUT: "logout",

    ROUTE_ADMIN_HOME: "admin.home",
    ROUTE_ADMIN_TEMP_HOME: "admin.temp.home",
    ROUTE_ADMIN_MEDIA: "admin.media",

    ROUTE_ADMIN_PRODUCTS_INDEX: "admin.products.index",
    ROUTE_ADMIN_PRODUCTS_CREATE: "admin.products.create",
    ROUTE_ADMIN_PRODUCTS_EDIT: "admin.products.edit",

    ROUTE_ADMIN_PRODUCTS_TEMP_INDEX: "admin.products.temp.index",
    ROUTE_ADMIN_PRODUCTS_TEMP_CREATE: "admin.products.temp.create",
    ROUTE_ADMIN_PRODUCTS_TEMP_EDIT: "admin.products.temp.edit",

    ROUTE_ADMIN_CATEGORIES_INDEX: "admin.categories.index",
    ROUTE_ADMIN_CATEGORIES_CREATE: "admin.categories.create",
    ROUTE_ADMIN_CATEGORIES_EDIT: "admin.categories.edit",

    ROUTE_ADMIN_CATEGORIES_TEMP_INDEX: "admin.categories.temp.index",
    ROUTE_ADMIN_CATEGORIES_TEMP_CREATE: "admin.categories.temp.create",
    ROUTE_ADMIN_CATEGORIES_TEMP_EDIT: "admin.categories.temp.edit",

    ROUTE_ADMIN_BRANDS_INDEX: "admin.brands.index",
    ROUTE_ADMIN_BRANDS_CREATE: "admin.brands.create",
    ROUTE_ADMIN_BRANDS_EDIT: "admin.brands.edit",

    ROUTE_ADMIN_BRANDS_TEMP_INDEX: "admin.brands.temp.index",
    ROUTE_ADMIN_BRANDS_TEMP_CREATE: "admin.brands.temp.create",
    ROUTE_ADMIN_BRANDS_TEMP_EDIT: "admin.brands.temp.edit",

    ROUTE_ADMIN_ORDERS_INDEX: "admin.orders.index",
    ROUTE_ADMIN_ORDERS_CREATE: "admin.orders.create",
    ROUTE_ADMIN_ORDERS_EDIT: "admin.orders.edit",

    ROUTE_ADMIN_ORDERS_TEMP_INDEX: "admin.orders.temp.index",
    ROUTE_ADMIN_ORDERS_TEMP_CREATE: "admin.orders.temp.create",
    ROUTE_ADMIN_ORDERS_TEMP_EDIT: "admin.orders.temp.edit",

    ROUTE_ADMIN_ARTICLES_INDEX: "admin.articles.index",
    ROUTE_ADMIN_ARTICLES_CREATE: "admin.articles.create",
    ROUTE_ADMIN_ARTICLES_EDIT: "admin.articles.edit",

    ROUTE_ADMIN_SERVICES_INDEX: "admin.services.index",
    ROUTE_ADMIN_SERVICES_CREATE: "admin.services.create",
    ROUTE_ADMIN_SERVICES_EDIT: "admin.services.edit",

    ROUTE_ADMIN_FAQ_INDEX: "admin.faq.index",
    ROUTE_ADMIN_FAQ_CREATE: "admin.faq.create",
    ROUTE_ADMIN_FAQ_EDIT: "admin.faq.edit",

    ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX: "admin.export-products.index",
    ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW: "admin.export-products.show",
    ROUTE_ADMIN_EXPORT_PRODUCTS_STORE: "admin.export-products.store",
    ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE: "admin.export-products.delete",

    ROUTE_ADMIN_AJAX_PRODUCTS_BULK_UPDATE: "admin-ajax.products.bulk.update",
    ROUTE_ADMIN_AJAX_PRODUCTS_BULK_DELETE: "admin-ajax.products.bulk.delete",

    ROUTE_ADMIN_AJAX_CATEGORIES_BULK_UPDATE:
        "admin-ajax.categories.bulk.update",
    ROUTE_ADMIN_AJAX_CATEGORIES_BULK_DELETE:
        "admin-ajax.categories.bulk.delete",

    ROUTE_ADMIN_AJAX_BRANDS_BULK_UPDATE: "admin-ajax.brands.bulk.update",
    ROUTE_ADMIN_AJAX_BRANDS_BULK_DELETE: "admin-ajax.brands.bulk.delete",

    ROUTE_ADMIN_AJAX_PRODUCTS_STORE: "admin-ajax.products.store",
    ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE: "admin-ajax.products.update",

    ROUTE_ADMIN_AJAX_CATEGORIES_STORE: "admin-ajax.categories.store",
    ROUTE_ADMIN_AJAX_CATEGORIES_UPDATE: "admin-ajax.categories.update",

    ROUTE_ADMIN_AJAX_BRANDS_STORE: "admin-ajax.brands.store",
    ROUTE_ADMIN_AJAX_BRANDS_UPDATE: "admin-ajax.brands.update",

    ROUTE_ADMIN_AJAX_FAQ_STORE: 'admin-ajax.faq.store',
    ROUTE_ADMIN_AJAX_FAQ_UPDATE: 'admin-ajax.faq.update',

    ROUTE_ADMIN_AJAX_ORDERS_STORE: "admin-ajax.orders.store",
    ROUTE_ADMIN_AJAX_ORDERS_UPDATE: "admin-ajax.orders.update",
    ROUTE_ADMIN_AJAX_ORDERS_CANCEL: "admin-ajax.orders.cancel",

    ROUTE_ADMIN_AJAX_ORDER_EVENTS_INDEX: "admin-ajax.order-event.index",

    ROUTE_ADMIN_AJAX_SORT_COLUMNS: "admin-ajax.sort-columns",
    ROUTE_ADMIN_AJAX_HELPER: "admin-ajax.helper",

    ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD: "admin-ajax.product-image-upload",
    ROUTE_ADMIN_AJAX_CATEGORY_IMAGE_UPLOAD: "admin-ajax.category-image-upload",
    ROUTE_ADMIN_AJAX_BRAND_IMAGE_UPLOAD: "admin-ajax.brand-image-upload",

    ROUTE_ADMIN_AJAX_PRODUCT_SEARCH: "admin-ajax.product-search",
}

enum RouteNameGroupEnum {
    Products = "admin.products.*",
    Categories = "admin.categories.*",
    Brands = "admin.brands.*",
    Articles = "admin.articles.*",
    Services = "admin.services.*",
    Faq = "admin.faq.*",
    Contacts = "admin.contacts.*",
}

export enum RouteTypeEnum {
    categoriesSub = "categories-sub",
    categories = "categories",
    reference = "reference",
    referenceBrands = "reference-brands",
    referenceArticles = "reference-articles",
    referenceServices = "reference-services",
    referenceFaq = "reference-faq",
    referenceContacts = "reference-contacts",
}
