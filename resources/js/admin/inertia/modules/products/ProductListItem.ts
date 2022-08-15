export default interface ProductListItem {
    id: number
    uuid: string
    name: string | null
    ordering: number | null
    is_active: boolean | null
    unit: string | null
    price_purchase: number | null
    price_purchase_currency_id: number | null
    price_purchase_formatted: string | null
    price_retail: number | null
    price_retail_currency_id: number | null
    price_retail_formatted: string | null
    admin_comment: string | null
    availability_status_id: number | null
    brand_id: number | null
    availability_status_name: string | null
    availability_status_name_short: string | null
}
