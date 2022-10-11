export interface Service {
    id: number
    uuid: string
    name: string
    slug: string
    ordering: number | null
    description: string | null
    group_id: number
    is_active: boolean
    created_at: string | null
    updated_at: string | null
}
