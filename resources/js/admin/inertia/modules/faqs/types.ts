import { Seo } from "@/admin/inertia/modules/common/types"

export interface FaqListItem {
    id: number
    uuid: string
    name: string | null
    slug: string | null
    parent_id: number | null
    is_active: boolean
}

export interface Faq {
    id: number
    uuid: string
    name: string | null
    slug: string | null
    parent_id: number | null
    question: string | null
    answer: string | null
    is_active: boolean
    seo: Seo | null
}
