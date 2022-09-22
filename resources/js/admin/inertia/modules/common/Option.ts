import { UrlParams } from "@/admin/inertia/modules/common/types"

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
