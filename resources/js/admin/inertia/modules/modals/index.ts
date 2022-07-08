import { defineStore } from "pinia"
import { DefineComponent } from "@vue/runtime-core"
import SortColumnsModal from "@/admin/inertia/components/modals/SortColumnsModal.vue"

export const storeName = "modals"

export const useModalsStore = defineStore(storeName, {
    state: (): { _types: { [key in ModalType]?: ModalPayload } } => {
        return {
            _types: {},
        }
    },
    getters: {
        types: (state): Array<ModalPayload> => Object.values(state._types),
    },
    actions: {
        openModal(type: ModalType, props?: any): void {
            this._types[type] = {
                type,
                props,
            }
        },
        closeModal(type: ModalType): void {
            delete this._types[type]
        },
    },
})

export interface ModalPayload {
    type: ModalType
    props?: any
}

export enum ModalType {
    SORT_PRODUCTS_COLUMNS,
}

export const Modals: { [key in ModalType]: DefineComponent } = {
    [ModalType.SORT_PRODUCTS_COLUMNS]: SortColumnsModal,
}
