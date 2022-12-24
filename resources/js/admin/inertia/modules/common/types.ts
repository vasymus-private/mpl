import { DefineComponent } from "@vue/runtime-core"

export interface Errors {
    [key: string]: Array<string>
}

export interface WithUuid {
    uuid: string
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

    edit_mode = "edit_mode",
}

export interface Links {
    first: string | null
    last: string | null
    next: string | null
    prev: string | null
}

export interface Media {
    id: number | null
    uuid: string | null
    url: string | null
    name: string | null
    file_name: string | null
    order_column: number | null
    file?: File | null
}

export interface AdminTab {
    value: TabEnum
    label: string
    is: DefineComponent
}

export enum TabEnum {
    elements = "elements",
    description = "description",
    photo = "photo",
    characteristics = "characteristics",
    seo = "seo",
    accessories = "accessories",
    similar = "similar",
    related = "related",
    works = "works",
    instruments = "instruments",
    variations = "variations",
    other = "other",

    products = "products",
    order = "order",
    history = "history",

    questionAnswer = "questionAnswer",
}

export interface Option {
    value: string | number
    label: string
    disabled?: boolean
    type?: OptionType
    urlParam?: UrlParams
}

export enum OptionType {
    category = "category",
    brand = "brand",
}

export interface Meta {
    current_page: number
    from: number
    last_page: number
    path: string
    per_page: number
    to: number
    total: number
    links: Array<MetaLink>
}

export interface MetaLink {
    active: boolean
    label: string
    url: string | null
    isPrev?: boolean
    isNext?: boolean
    isSeparator?: boolean
    page?: number
}
