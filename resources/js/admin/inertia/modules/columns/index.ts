import { defineStore } from "pinia"
import Column from "@/admin/inertia/modules/columns/Column"

export const storeName = "columns"

export const useColumnsStore = defineStore(storeName, {
    state: (): {
        _adminOrderColumns: Array<Column>
        _adminProductColumns: Array<Column>
        _adminProductVariantColumns: Array<Column>
    } => {
        return {
            _adminOrderColumns: [],
            _adminProductColumns: [],
            _adminProductVariantColumns: [],
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
            this._adminOrderColumns = columns
        },
        setAdminProductVariantColumns(columns: Array<Column>): void {
            this._adminProductVariantColumns = columns
        },
    },
})
