import { Seo } from "@/admin/inertia/modules/common/types"
import Media from "@/admin/inertia/modules/common/Media"

export interface BrandListItem {
    id: number
    name: string | null
    ordering: number | null
    preview: string | null
}

export interface Brand {
    id: number
    name: string | null
    slug: string | null
    ordering: number | null
    preview: string | null
    description: string | null
    mainImage: Media | null
    seo: Seo | null
}
