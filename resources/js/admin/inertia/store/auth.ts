import { defineStore } from "pinia"
import Auth from "@/admin/inertia/entities/Auth"
import User from "@/admin/inertia/entities/User";


export const AUTH_STORE = 'auth'

// useStore could be anything like useUser, useCart
// the first argument is a unique id of the store across your application
export const useAuthStore = defineStore(AUTH_STORE, {
    state: (): Auth => {
        return {
            user: {
                id: null,
                name: null,
                email: null,
                phone: null,
                is_anonymous: null
            }
        }
    },
    getters: {
        userName: (state): string|null => state.user.name
    },
    actions: {
        setAuthUser(user: User): void {
            this.user = user
        }
    }
})
