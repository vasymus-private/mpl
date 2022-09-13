import { defineStore } from "pinia"
import { DefineComponent } from "@vue/runtime-core"
import SortColumnsModal from "@/admin/inertia/components/modals/SortColumnsModal.vue"
import CreateEditVariation from "@/admin/inertia/components/products/createEdit/modals/CreateEditVariation.vue"
import { ModalType, ModalPayload } from "@/admin/inertia/modules/modals/types"

export const storeName = "modals"

interface State {
    _types: {
        [key in ModalType]?: ModalPayload
    }
}

export const useModalsStore = defineStore(storeName, {
    state: (): State => {
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

export const Modals: { [key in ModalType]: DefineComponent } = {
    [ModalType.SORT_ADMIN_COLUMNS]: SortColumnsModal,
    [ModalType.CREATE_EDIT_VARIATION]: CreateEditVariation,
}
