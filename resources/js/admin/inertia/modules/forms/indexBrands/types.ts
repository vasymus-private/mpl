import { BrandListItem } from "@/admin/inertia/modules/brands/types"

export interface Values {
    brands: Array<Partial<BrandListItem>>
}

export interface BrandsResponse {
    data: Array<BrandListItem>
}
