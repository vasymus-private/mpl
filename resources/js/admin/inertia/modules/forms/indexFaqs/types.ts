import {FaqListItem} from "@/admin/inertia/modules/faqs/types"

export interface Values {
    faqs: Array<Partial<FaqListItem>>
}

export interface FaqsResponse {
    data: Array<FaqListItem>
}
