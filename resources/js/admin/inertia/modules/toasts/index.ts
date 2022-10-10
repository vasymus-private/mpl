import { defineStore } from "pinia"
import {
    ToastProps,
    ToastPayload,
    ToastType,
} from "@/admin/inertia/modules/toasts/types"
import { DefineComponent } from "@vue/runtime-core"
import { randomId } from "@/admin/inertia/utils"

export const storeName = "toasts"

interface State {
    _types: Array<ToastPayload>
}

export const useToastsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _types: [],
        }
    },
    getters: {
        types: (state): Array<ToastPayload> => state._types,
    },
    actions: {
        openToast(type: ToastType, props?: ToastProps): void {
            this._types.push({
                type,
                props: {
                    ...props,
                    _uuid: props._uuid || randomId(),
                },
            })
        },
        /**
         * Shortcut of this.openToast()
         */
        error(props: ToastProps): void {
            this.openToast(ToastType.ERROR, props)
        },
        /**
         * Shortcut of this.openToast()
         */
        info(props: ToastProps): void {
            this.openToast(ToastType.INFO, props)
        },
        closeToast(uuid: string): void {
            this._types = this._types.filter(
                (payload) => payload.props._uuid !== uuid
            )
        },
    },
})

export const Toasts: { [key in ToastType]: () => DefineComponent } = {
    [ToastType.INFO]: () => require("@/admin/inertia/components/toasts/Toast.vue").default,
    [ToastType.ERROR]: () => require("@/admin/inertia/components/toasts/Toast.vue").default,
}

export const DELAY_DEFAULT = 7000
