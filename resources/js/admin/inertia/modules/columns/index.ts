import { defineStore } from "pinia"
import {
    Column,
    ColumnName,
    ColumnSize,
} from "@/admin/inertia/modules/columns/types"
import axios from "axios"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import { useAuthStore } from "@/admin/inertia/modules/auth"
import { ProfileUpdateResponse } from "@/admin/inertia/modules/common/types"

export const storeName = "columns"

interface State {
    _adminOrderColumns: Array<Column>
    _adminProductColumns: Array<Column>
    _adminProductVariantColumns: Array<Column>
    _loading: boolean
    _adminProductsColumnSizes: Array<ColumnSize>
    _adminProductVariationsColumnSizes: Array<ColumnSize>
    _adminOrdersColumnSizes: Array<ColumnSize>
}

export const useColumnsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _adminOrderColumns: [],
            _adminProductColumns: [],
            _adminProductVariantColumns: [],
            _loading: false,
            _adminProductsColumnSizes: [],
            _adminProductVariationsColumnSizes: [],
            _adminOrdersColumnSizes: [],
        }
    },
    getters: {
        adminOrderColumns: (state: State): Array<Column> =>
            state._adminOrderColumns,
        adminProductColumns: (state: State): Array<Column> =>
            state._adminProductColumns,
        adminProductVariantColumns: (state: State): Array<Column> =>
            state._adminProductVariantColumns,
        adminProductsColumnSize(state: State) {
            return (column: Column): ColumnSize | undefined => {
                return state._adminProductsColumnSizes.find(
                    (columnSize) => columnSize.column.value === column.value
                )
            }
        },
        adminProductsColumnWidth() {
            return (column: Column): string => {
                const columnSize = this.adminProductsColumnSize(column) as
                    | ColumnSize
                    | undefined
                if (!columnSize) {
                    return "auto"
                }

                if (typeof columnSize.width === "number") {
                    return `${columnSize.width}px`
                }

                return columnSize.width
            }
        },
        adminProductVariationsColumnSize(state: State) {
            return (column: Column): ColumnSize | undefined => {
                return state._adminProductVariationsColumnSizes.find(
                    (columnSize) => columnSize.column.value === column.value
                )
            }
        },
        adminOrdersColumnSize(state: State) {
            return (column: Column): ColumnSize | undefined => {
                return state._adminOrdersColumnSizes.find(
                    (columnSize) => columnSize.column.value === column.value
                )
            }
        },
    },
    actions: {
        setAdminOrderColumns(columns: Array<Column>): void {
            this._adminOrderColumns = columns
        },
        setAdminProductColumns(columns: Array<Column>): void {
            this._adminProductColumns = columns
        },
        setAdminProductVariantColumns(columns: Array<Column>): void {
            this._adminProductVariantColumns = columns
        },
        setAdminProductsColumnSizes(sizes: Array<ColumnSize>): void {
            this._adminProductsColumnSizes = sizes
        },
        setAdminProductVariationsColumnSizes(sizes: Array<ColumnSize>): void {
            this._adminProductVariationsColumnSizes = sizes
        },
        setAdminOrdersColumnSizes(sizes: Array<ColumnSize>): void {
            this._adminOrdersColumnSizes = sizes
        },
        async handleSortColumns(
            requestParams: SortColumnsRequestParams
        ): Promise<void> {
            this._loading = true
            try {
                const routesStore = useRoutesStore()
                const authStore = useAuthStore()

                const {
                    data: {
                        settings: {
                            adminOrderColumns,
                            adminProductColumns,
                            adminProductVariantColumns,
                        },
                    },
                    status,
                    statusText,
                } = await axios.put<ProfileUpdateResponse>(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_PROFILE_UPDATE,
                        { admin: authStore.userId }
                    ),
                    requestParams
                )

                if (status >= 400) {
                    throw new Error(statusText)
                }

                this.setAdminOrderColumns(adminOrderColumns)
                this.setAdminProductColumns(adminProductColumns)
                this.setAdminProductVariantColumns(adminProductVariantColumns)
            } catch (e) {
                console.warn(e)
            } finally {
                this._loading = false
            }
        },
    },
})

/**
 * @see src/Domain/Common/Enums/Column.php
 */
export const getColumn = (key: ColumnName): Column => {
    const obj = {
        [ColumnName.id]: {
            value: 1,
            label: "ID",
        },
        [ColumnName.name]: {
            value: 2,
            label: "Имя",
        },
        [ColumnName.date_creation]: {
            value: 3,
            label: "Дата создания",
        },
        [ColumnName.status]: {
            value: 4,
            label: "Статус",
        },
        [ColumnName.positions]: {
            value: 5,
            label: "Позиции",
        },
        [ColumnName.comment_admin]: {
            value: 6,
            label: "Комментарии",
        },
        [ColumnName.importance]: {
            value: 7,
            label: "Важность",
        },
        [ColumnName.manager]: {
            value: 8,
            label: "Менеджер",
        },
        [ColumnName.sum]: {
            value: 9,
            label: "Сумма",
        },
        [ColumnName.phone]: {
            value: 10,
            label: "Телефон",
        },
        [ColumnName.email]: {
            value: 11,
            label: "Email",
        },
        [ColumnName.comment_user]: {
            value: 12,
            label: "Комментарий покупателя",
        },
        [ColumnName.payment_method]: {
            value: 13,
            label: "Платежная система",
        },
        [ColumnName.unit]: {
            value: 14,
            label: "Упаковка",
        },
        [ColumnName.price_purchase]: {
            value: 15,
            label: "Закупочная",
        },
        [ColumnName.price_retail]: {
            value: 16,
            label: "Розничная",
        },
        [ColumnName.admin_comment]: {
            value: 17,
            label: "Служебная Информация",
        },
        [ColumnName.availability]: {
            value: 18,
            label: "Наличие",
        },
        [ColumnName.active]: {
            value: 19,
            label: "Акт-ть",
        },
        [ColumnName.detailed_image]: {
            value: 20,
            label: "Детальная картинка",
        },
        [ColumnName.additional_images]: {
            value: 21,
            label: "Дополнительные фото",
        },
        [ColumnName.ordering]: {
            value: 22,
            label: "Сорт-ка",
        },
        [ColumnName.coefficient]: {
            value: 23,
            label: "Коэффициент",
        },
        [ColumnName.coefficient_description]: {
            value: 24,
            label: "Описание коэффициента",
        },
        [ColumnName.categories]: {
            value: 25,
            label: "Разделы",
        },
    }

    return obj[key]
}

export const isSortableColumn = (column: Column, name: ColumnName): boolean =>
    column.value === getColumn(name).value

interface SortColumnsRequestParams {
    adminOrderColumns?: Array<number>
    adminOrderColumnsDefault?: boolean
    adminProductColumns?: Array<number>
    adminProductColumnsDefault?: boolean
    adminProductVariantColumns?: Array<number>
    adminProductVariantColumnsDefault?: boolean
}
