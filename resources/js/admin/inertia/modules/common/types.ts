export interface Errors {
    [key: string]: Array<string>
}

export interface WithId {
    id: string | number
}

export interface Seo {
    title: string | null
    h1: string | null
    keywords: string | null
    description: string | null
}

export interface ErrorResponse {
    data: {
        errors: Errors
    }
}

export enum UrlParams {
    brand_id = "brand_id",
    category_id = "category_id",
    page = "page",
    per_page = "per_page",
    search = "search",

    date_from = "date_from",
    date_to = "date_to",
    order_id = "order_id",
    email = "email",
    name = "name",
    admin_id = "admin_id",

    copy_id = "copy_id",

    active_tab = "active_tab",
}
