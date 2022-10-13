import {
    Variation,
    Product,
    Char,
} from "@/admin/inertia/modules/products/types"

export interface Values
    extends Partial<Omit<Product, "parent_id" | "web_route">> {
    chars?: Array<CharValue>
    tempCharCategoryName?: string | null
    tempChar?: TempChar | null
}

export interface CharValue extends Partial<Omit<Char, "is_rate">> {}

export interface TempChar {
    name?: string | null
    type_id?: number | null
    category_uuid?: string | null
}

export interface VariationForm extends Partial<Variation> {
}
