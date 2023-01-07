import { Seo } from "@/admin/inertia/modules/common/types"

export interface ArticleListItem {
    id: number
    uuid: string
    name: string | null
    slug: string | null
    parent_id: number | null
    is_active: boolean
}

export interface Article {
    id: number
    uuid: string
    name: string
    slug: string
    description: string
    parent_id: number
    is_active: boolean
    seo: Seo | null
    web_route: string
}
