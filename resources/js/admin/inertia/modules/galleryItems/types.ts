import {Media, Seo} from "@/admin/inertia/modules/common/types"

export interface GalleryItemListItem {
    id: number
    uuid: string
    name: string|null
    slug: string|null
    parent_id: number|null
    is_active: boolean
    ordering: number
}

export interface GalleryItem {
    id: number
    uuid: string
    name: string|null
    slug: string|null
    parent_id: number|null
    is_active: boolean
    description: string|null
    seo: Seo|null
    web_route: string|null
    mainImage: Media | null
    ordering: number
}
