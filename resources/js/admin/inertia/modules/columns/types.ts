export interface Column {
    value: number
    label: string
}

export enum ColumnType {
    adminOrderColumns,
    adminProductColumns,
    adminProductVariantColumns,
}

export enum ResizeColumnType {
    adminOrderColumns = 'adminProductsColumnSizes',
    adminProductColumns = 'adminProductVariationsColumnSizes',
    adminProductVariantColumns = 'adminOrdersColumnSizes',
}

export enum ColumnName {
    id = "id",
    name = "name",
    date_creation = "date_creation",
    status = "status",
    positions = "positions",
    comment_admin = "comment_admin",
    importance = "importance",
    manager = "manager",
    sum = "sum",
    phone = "phone",
    email = "email",
    comment_user = "comment_user",
    payment_method = "payment_method",
    unit = "unit",
    price_purchase = "price_purchase",
    price_retail = "price_retail",
    admin_comment = "admin_comment",
    availability = "availability",
    active = "active",
    detailed_image = "detailed_image",
    additional_images = "additional_images",
    ordering = "ordering",
    coefficient = "coefficient",
    coefficient_description = "coefficient_description",
    categories = "categories",
}

export interface ColumnSize {
    column: Column
    width: number | string
}

export interface SortColumnsRequestParams {
    adminOrderColumns?: Array<number>
    adminOrderColumnsDefault?: boolean
    adminProductColumns?: Array<number>
    adminProductColumnsDefault?: boolean
    adminProductVariantColumns?: Array<number>
    adminProductVariantColumnsDefault?: boolean
}

export interface SizeColumnsRequestParams {

}
