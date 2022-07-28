export default interface Column {
    value: number
    label: string
}

export enum ColumnType {
    adminOrderColumns,
    adminProductColumns,
    adminProductVariantColumns,
}
