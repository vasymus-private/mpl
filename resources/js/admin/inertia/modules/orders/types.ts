import { DateTime } from "luxon"

interface OrderItem {
    id: number
    created_at: DateTime | null // parse from 'Y-m-d H:i:s'
    order_status_id: number | null
    comment_admin: string | null
    comment_user: string | null
    importance_id: number | null
    admin_id: number | null
    admin_name: string | null
    admin_color: string | null
    user_id: number | null
    user_name: string | null
    user_email: string | null
    user_phone: string | null
    order_price_retail_rub_formatted: string | null
    products: Array<OrderItemProductItem>
    payment_method_id: number | null
    is_busy_by_other_admin: boolean
}

interface Order {}

interface OrderItemProductItem {
    id: number
    name: string
    count: number
    unit: string
}
