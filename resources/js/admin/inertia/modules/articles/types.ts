export interface Article {
    id: number
    uuid: string
    name: string
    slug: string
    description: string
    parent_id: number
    is_active: boolean
    created_at: string | null
    updated_at: string | null
}
