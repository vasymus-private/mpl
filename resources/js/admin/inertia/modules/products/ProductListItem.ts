export default interface ProductListItem {
    id: number|null
    uuid: string|null
    name: string|null
    ordering: number|null
    is_active: boolean|null
    unit: string|null
    price_purchase: number|null
    price_purchase_currency_id: number|null
    price_retail: number|null
    price_retail_currency_id: number|null
    admin_comment: string|null
    availability_status_id: number|null
    brand_id: number|null
}
