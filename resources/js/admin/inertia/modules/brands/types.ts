import { Seo, Media } from "@/admin/inertia/modules/common/types"

export interface BrandListItem {
    id: number
    uuid: string
    name: string | null
    ordering: number | null
    preview: string | null
}

export interface Brand {
    id: number
    uuid: string
    name: string | null
    slug: string | null
    ordering: number | null
    preview: string | null
    description: string | null
    mainImage: Media | null
    seo: Seo | null
}
