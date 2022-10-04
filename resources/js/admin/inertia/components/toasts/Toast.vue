<script setup lang="ts">
import {ToastType, ToastProps} from "@/admin/inertia/modules/toasts/types"
import {computed} from "vue"
import {DELAY_DEFAULT, useToastsStore} from "@/admin/inertia/modules/toasts"


const props = defineProps<{
    type: ToastType,
    toastProps: ToastProps
}>()

const color = computed(() => {
    if (props.toastProps.color) {
        return props.toastProps.color
    }

    switch (props.type) {
        case ToastType.ERROR: {
            return '#dc3545'
        }
        case ToastType.INFO:
        default: {
            return '#007aff'
        }
    }
})
const title = computed(() => {
    if (props.toastProps.title) {
        return props.toastProps.title
    }

    switch (props.type) {
        case ToastType.ERROR: {
            return 'Ошибка'
        }
        case ToastType.INFO:
        default: {
            return 'Информация'
        }
    }
})

const toastsStore = useToastsStore()
const close = () => {
    toastsStore.closeToast(props.toastProps._uuid)
}

setTimeout(close, props.toastProps.delay || DELAY_DEFAULT)
</script>

<template>
    <div
        class="toast show fade"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        <div class="toast-header">
            <svg
                class="bd-placeholder-img rounded me-2"
                width="20"
                height="20"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
                preserveAspectRatio="xMidYMid slice"
                focusable="false"
            >
                <rect width="100%" height="100%" :fill="color"></rect>
            </svg>
            <strong class="me-auto">{{ title }}</strong>
            <button @click="close" type="button" class="btn-close" aria-label="Close"></button>
        </div>
        <div v-if="props.toastProps.message" class="toast-body">
            {{ props.toastProps.message }}
        </div>
    </div>
</template>
