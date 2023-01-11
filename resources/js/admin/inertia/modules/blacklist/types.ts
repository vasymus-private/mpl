import { IpDetails } from "@/admin/inertia/modules/common/types"
import { DateTime } from "luxon"

export interface BlacklistItem {
    id: number
    uuid: string
    ipDetails: IpDetails | null
    email: string
    ip: string | null
    created_at: string | null // parse from 'Y-m-d H:i:s'
    dt_created_at: DateTime | null // parse from 'Y-m-d H:i:s'
}

export interface Blacklist {
    id: number
    uuid: string
    ipDetails: IpDetails | null
    email: string
    ip: string | null
    created_at: string | null // parse from 'Y-m-d H:i:s'
    dt_created_at: DateTime | null // parse from 'Y-m-d H:i:s'
}
