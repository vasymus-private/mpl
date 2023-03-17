import { IpDetails, Media } from "@/admin/inertia/modules/common/types"
import { DateTime } from "luxon"

export interface ContactFormItem {
    id: number
    uuid: string
    type: number
    type_name: string
    email: string | null
    name: string | null
    phone: string | null
    ipDetails: IpDetails | null
    created_at: string | null // parse from 'Y-m-d H:i:s'
    dt_created_at: DateTime | null // parse from 'Y-m-d H:i:s'
    is_read_by_admin: boolean
}

export interface ContactForm {
    id: number
    uuid: string
    type: number
    type_name: string
    email: string | null
    name: string | null
    phone: string | null
    description: string | null
    ipDetails: IpDetails | null
    created_at: string | null // parse from 'Y-m-d H:i:s'
    dt_created_at: DateTime | null // parse from 'Y-m-d H:i:s'
    files: Array<Media>
}
