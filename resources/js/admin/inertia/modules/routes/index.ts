import { defineStore } from "pinia"
import { useCategoriesTreeStore } from "@/admin/inertia/modules/categoriesTree"
import route, { Config, RouteParam } from "ziggy-js"
import { Ziggy } from "@/helpers/ziggy"


export const storeName = "routes"

export const useRoutesStore = defineStore(storeName, {
    getters: {
        isActiveRoute:
            () =>
            (type: RouteTypeEnum, id: number | string = null): boolean => {
                const categoriesTreeStore = useCategoriesTreeStore()

                let router = route(
                    undefined,
                    undefined,
                    undefined,
                    Ziggy as Config
                )

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

                        let categoryAndSubtreeIds = categoriesTreeStore.getCategoryAndSubtreeIds(id)

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
    },
})

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

    ROUTE_ADMIN_AJAX_SORT_COLUMNS: "admin-ajax.sort-columns",
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

/**
 * @deprecated use {@link RouteTypeEnum}
 */
export const routeTypes = {
    categoriesSub: "categories-sub",
    categories: "categories",
    reference: "reference",
    referenceBrands: "reference-brands",
    referenceArticles: "reference-articles",
    referenceServices: "reference-services",
    referenceFaq: "reference-faq",
    referenceContacts: "reference-contacts",
}
