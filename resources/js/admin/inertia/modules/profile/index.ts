import { defineStore } from "pinia"
import {isNumeric} from "@/admin/inertia/utils"


export const storeName = "profile"
const ADMIN_SIDEBAR_FLEX_BASIS_DEFAULT = 330

interface State {
    _adminSidebarFlexBasis: string|null
}

export const useProfileStore = defineStore(storeName, {
    state: (): State => {
        return {
            _adminSidebarFlexBasis: null
        }
    },
    getters: {
        adminSidebarFlexBasis: (state): number => {
            const res = state._adminSidebarFlexBasis ? parseInt(state._adminSidebarFlexBasis) : ADMIN_SIDEBAR_FLEX_BASIS_DEFAULT

            return isNumeric(res) ? res : ADMIN_SIDEBAR_FLEX_BASIS_DEFAULT
        }
    },
    actions: {
        setAdminSidebarFlexBasis(value: number|string|null): void {
            if (isNumeric(value)) {
                this._adminSidebarFlexBasis = `${value}px`
                return
            }

            this._adminSidebarFlexBasis = value
            return
        }
    }
})
