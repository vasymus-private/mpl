import { BlacklistItem } from "@/admin/inertia/modules/blacklist/types"

export interface Values {
    blacklistItems: Array<Partial<BlacklistItem>>
}

export interface BlacklistItemsResponse {
    data: Array<BlacklistItem>
}
