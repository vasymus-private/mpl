import { defineStore } from "pinia"
import { useCategoriesTreeStore } from "@/admin/inertia/modules/categoriesTree"
import route, {
    Config,
    RouteParam,
    RouteParamsWithQueryOverload,
    Router,
} from "ziggy-js"
import { Ziggy } from "@/helpers/ziggy"
import Option, { OptionType } from "@/admin/inertia/modules/common/Option"
import { Inertia } from "@inertiajs/inertia"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import * as H from 'history'

export const storeName = "routes"

export const useRoutesStore = defineStore(storeName, {
    state: (): { _fullUrl: string | null } => {
        return {
            _fullUrl: null,
        }
    },
    getters: {
        fullUrl: (state): string | null => state._fullUrl,
        isActiveRoute:
            () =>
            (type: RouteTypeEnum, id: number | string = null): boolean => {
                const categoriesTreeStore = useCategoriesTreeStore()

                let router = getRouter()

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
                            categoriesTreeStore.getCategoryAndSubtreeIds(id)

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
            },
        getUrlParam() {
            return (key: UrlParams): string | null => {
                let fullUrl = this.fullUrl
                if (!fullUrl) {
                    return null
                }

                try {
                    let url = new URL(fullUrl)
                    return url.searchParams.get(key)
                } catch (e) {
                    console.warn(e)
                    return null
                }
            }
        },
        urlParamOptions(): Array<Option> {
            let categoryId = this.getUrlParam(UrlParams.category_id)
            let brandId = this.getUrlParam(UrlParams.brand_id)

            let result = []

            if (categoryId) {
                let categoriesStore = useCategoriesTreeStore()
                let category = categoriesStore.option(categoryId)
                if (category) {
                    result = [
                        ...result,
                        {
                            ...category,
                            type: OptionType.category,
                        },
                    ]
                }
            }

            if (brandId) {
                let brandsStore = useBrandsStore()
                let brand = brandsStore.option(brandId)
                if (brand) {
                    result = [
                        ...result,
                        {
                            ...brand,
                            type: OptionType.brand,
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
            ): string|null => {
                if (!this.fullUrl) {
                    return null
                }
                let u = new URL(this.fullUrl)
                let location = {
                    host: u.host,
                    pathname: u.pathname,
                    search: u.search,
                    state: typeof history !== 'undefined' ? history.state : {},
                    hash: u.hash
                } as H.Location
                let config = {
                    ...Ziggy,
                    location
                } as Config

                return route(name, params, undefined, config)
            }
        },
        router(): Router|null {
            if (!this.fullUrl) {
                return null
            }

            let u = new URL(this.fullUrl)
            let location = {
                host: u.host,
                pathname: u.pathname,
                search: u.search,
                state: typeof history !== 'undefined' ? history.state : {},
                hash: u.hash
            } as H.Location
            let config = {
                ...Ziggy,
                location
            } as Config

            return route(undefined, undefined, undefined, config)
        },
        current(): string|null {
            return this.router ? this.router.current() : null
        }
    },
    actions: {
        setFullUrl(fullUrl: string | null): void {
            this._fullUrl = fullUrl
        },
    },
})

let _router: Router
export const getRouter = () => {
    if (typeof _router !== "undefined") {
        return _router
    }

    _router = route(undefined, undefined, undefined, Ziggy as Config)

    return _router
}

export const getRouteUrl = (
    name: string,
    params?: RouteParamsWithQueryOverload | RouteParam
): string => route(name, params, undefined, Ziggy as Config)

export const routeNames = {
    ROUTE_WEB_HOME: "home",
    ROUTE_LOGOUT: "logout",

    ROUTE_ADMIN_HOME: "admin.home",
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

    ROUTE_ADMIN_BRANDS_INDEX: "admin.brands.index",
    ROUTE_ADMIN_BRANDS_CREATE: "admin.brands.create",
    ROUTE_ADMIN_BRANDS_EDIT: "admin.brands.edit",

    ROUTE_ADMIN_ORDERS_INDEX: "admin.orders.index",
    ROUTE_ADMIN_ORDERS_CREATE: "admin.orders.create",
    ROUTE_ADMIN_ORDERS_EDIT: "admin.orders.edit",

    ROUTE_ADMIN_ARTICLES_INDEX: "admin.articles.index",
    ROUTE_ADMIN_ARTICLES_CREATE: "admin.articles.create",
    ROUTE_ADMIN_ARTICLES_EDIT: "admin.articles.edit",

    ROUTE_ADMIN_SERVICES_INDEX: "admin.services.index",
    ROUTE_ADMIN_SERVICES_CREATE: "admin.services.create",
    ROUTE_ADMIN_SERVICES_EDIT: "admin.services.edit",

    ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX: "admin.export-products.index",
    ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW: "admin.export-products.show",
    ROUTE_ADMIN_EXPORT_PRODUCTS_STORE: "admin.export-products.store",
    ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE: "admin.export-products.delete",

    ROUTE_ADMIN_AJAX_PRODUCTS_BULK_UPDATE: "admin-ajax.products.bulk.update",
    ROUTE_ADMIN_AJAX_PRODUCTS_STORE: "admin-ajax.products.store",
    ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE: "admin-ajax.products.update",
    ROUTE_ADMIN_AJAX_SORT_COLUMNS: "admin-ajax.sort-columns",
    ROUTE_ADMIN_AJAX_HELPER: "admin-ajax.helper",
    ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD: "admin-ajax.product-image-upload",
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

export enum RouteParams {
    activeTab = "activeTab",
}

export enum UrlParams {
    brand_id = "brand_id",
    category_id = "category_id",
    page = "page",
    per_page = "per_page",
    search = "search",
}
export const visit = (
    params: Partial<Record<UrlParams, string | number | null>>
) => {
    const to = new URL(location.href)

    for (let key in params) {
        if (!params[key]) {
            to.searchParams.delete(key)
        }
        if (params[key]) {
            to.searchParams.set(key, `${params[key]}`)
        }
    }

    Inertia.visit(to.toString())
}
