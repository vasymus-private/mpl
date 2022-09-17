import { defineStore } from "pinia"
import Auth from "@/admin/inertia/modules/auth/Auth"
import User from "@/admin/inertia/modules/auth/User"
import {Admin} from "@/admin/inertia/modules/auth/types"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "auth"

interface State {
    auth: Auth
    _admins: Array<Admin>
}

export const useAuthStore = defineStore(storeName, {
    state: (): State => {
        return {
            auth: {
                user: {
                    id: null,
                    name: null,
                    email: null,
                    phone: null,
                    is_anonymous: null,
                    is_super_admin: null,
                },
            },
            _admins: [],
        }
    },
    getters: {
        userName: (state): string | null => state.auth.user.name,
        adminOptions: (state): Array<Option> => state._admins.map(admin => ({value: admin.id, label: admin.name}))
    },
    actions: {
        setAuthUser(user: User): void {
            this.auth.user = user
        },
        setAdmins(admins: Array<Admin>): void {
            this._admins = admins
        },
    },
})
