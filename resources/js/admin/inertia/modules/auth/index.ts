import { defineStore } from "pinia"
import { Auth, User } from "@/admin/inertia/modules/auth/types"
import { Admin } from "@/admin/inertia/modules/auth/types"
import { Option } from "@/admin/inertia/modules/common/types"

export const storeName = "auth"

interface State {
    _auth: Auth
    _admins: Array<Admin>
}

export const useAuthStore = defineStore(storeName, {
    state: (): State => {
        return {
            _auth: {
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
        userName: (state): string | null => state._auth.user.name,
        adminOptions: (state): Array<Option> =>
            state._admins.map((admin) => ({
                value: admin.id,
                label: admin.name,
            })),
        admin(state): (id: number) => Admin | undefined {
            return (id: number) => state._admins.find((item) => item.id === id)
        },
        auth: (state): Auth => state._auth,
    },
    actions: {
        setAuthUser(user: User): void {
            this._auth.user = user
        },
        setAdmins(admins: Array<Admin>): void {
            this._admins = admins
        },
    },
})
