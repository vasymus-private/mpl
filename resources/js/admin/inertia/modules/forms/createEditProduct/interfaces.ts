import { Variation } from "@/admin/inertia/modules/products/Product"

export interface VariationForm extends Partial<Variation> {
    is_checked?: boolean
}
