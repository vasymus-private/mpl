import { DateTime } from "luxon"
import { Media } from "@/admin/inertia/modules/common/types"

export interface OrderItem {
    id: number
    uuid: string
    created_at: string | null // parse from 'Y-m-d H:i:s'
    dt_created_at: DateTime | null
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
    request_user_name: string | null
    request_user_email: string | null
    request_user_phone: string | null
    products: Array<OrderItemProductItem>
    payment_method_id: number | null
    is_busy_by_other_admin: boolean
}

export interface Order {
    id: number
    uuid: string
    user_id: number | null
    user_name: string | null
    user_email: string | null
    user_phone: string | null
    request_user_name: string | null
    request_user_email: string | null
    request_user_phone: string | null
    order_status_id: number | null
    cancelled: boolean
    cancelled_description: string | null
    payment_method_id: number | null
    comment_user: string | null
    initial_attachments: Array<Media>
    payment_method_attachments: Array<Media>
    admin_id: number | null
    admin_name: string | null
    admin_color: string | null
    importance_id: number | null
    customer_bill_description: string | null
    customer_bill_status_id: string | null
    customer_invoices: Array<Media>
    provider_bill_status_id: number | null
    provider_bill_description: string | null
    supplier_invoices: Array<Media>
    comment_admin: string | null
    products: Array<OrderProductItem>
    created_at: string | null // parse from 'Y-m-d H:i:s'
    dt_created_at: DateTime | null // parse from 'Y-m-d H:i:s'
    updated_at: string | null // parse from 'Y-m-d H:i:s'
    dt_updated_at: DateTime | null // parse from 'Y-m-d H:i:s'
    is_busy_by_other_admin: boolean
    busy_by_name: string | null
}

export interface OrderItemProductItem {
    id: number
    uuid: string
    name: string
    unit: string | null
    order_product_name: string | null
    order_product_unit: string | null
    order_product_count: number
    order_product_price_retail_rub: number
}

export interface OrderProductItem {
    id: number
    uuid: string
    parent_id: number | null
    name: string
    unit: string | null
    price_purchase: number | null
    price_purchase_currency_id: number | null
    price_retail: number | null
    price_retail_currency_id: number | null
    coefficient: number | null
    availability_status_id: number | null
    order_product_count: number
    order_product_name: string | null
    order_product_unit: string | null
    order_product_ordering: number
    order_product_price_retail_rub: number
    order_product_price_retail_rub_origin: number
    order_product_price_retail_rub_was_updated: boolean
}

export interface OrderEvent {
    id: number
    userName: string | null
    operation: string
    description: string
    created_at: string | null
    dt_created_at: DateTime | null // parse from 'Y-m-d H:i:s'
}
