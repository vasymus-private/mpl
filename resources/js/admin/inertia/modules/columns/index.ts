import { defineStore } from "pinia"
import Column from "@/admin/inertia/modules/columns/Column"
import axios from "axios"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"

export const storeName = "columns"

export const useColumnsStore = defineStore(storeName, {
    state: (): {
        _adminOrderColumns: Array<Column>
        _adminProductColumns: Array<Column>
        _adminProductVariantColumns: Array<Column>
        _loading: boolean
    } => {
        return {
            _adminOrderColumns: [],
            _adminProductColumns: [],
            _adminProductVariantColumns: [],
            _loading: false,
        }
    },
    getters: {
        adminOrderColumns: (state): Array<Column> => state._adminOrderColumns,
        adminProductColumns: (state): Array<Column> =>
            state._adminProductColumns,
        adminProductVariantColumns: (state): Array<Column> =>
            state._adminProductVariantColumns,
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
        async handleSortColumns(
            requestParams: SortColumnsRequestParams
        ): Promise<void> {
            this._loading = true
            try {
                const routesStore = useRoutesStore()

                const {
                    data: {
                        data: {
                            adminOrderColumns,
                            adminProductColumns,
                            adminProductVariantColumns,
                        },
                    },
                    status,
                    statusText,
                } = await axios.put<SortColumnsResponse>(
                    routesStore.route(routeNames.ROUTE_ADMIN_AJAX_SORT_COLUMNS),
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

type SortColumnsResponse = {
    data: {
        adminOrderColumns: Array<Column>
        adminProductColumns: Array<Column>
        adminProductVariantColumns: Array<Column>
    }
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
}

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
