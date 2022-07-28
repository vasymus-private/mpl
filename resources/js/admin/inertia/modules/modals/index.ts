import { defineStore } from "pinia"
import { DefineComponent } from "@vue/runtime-core"
import SortColumnsModal from "@/admin/inertia/components/modals/SortColumnsModal.vue"
import CreateEditVariation from '@/admin/inertia/components/products/tabs/modals/CreateEditVariation.vue'

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
        openModal(type: ModalType, props?: object): void {
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
    props?: object
}

export enum ModalType {
    SORT_ADMIN_COLUMNS,
    CREATE_EDIT_VARIATION,
}

export const Modals: { [key in ModalType]: DefineComponent } = {
    [ModalType.SORT_ADMIN_COLUMNS]: SortColumnsModal,
    [ModalType.CREATE_EDIT_VARIATION]: CreateEditVariation,
}
