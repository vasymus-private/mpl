import { UrlParams } from "@/admin/inertia/composables/useRoute"

export default interface Option {
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
