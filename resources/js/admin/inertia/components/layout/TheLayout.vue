<script lang="ts" setup>
import TheHeader from "@/admin/inertia/components/layout/TheHeader.vue"
import TheSidebar from "@/admin/inertia/components/layout/TheSidebar.vue"
import {Modals, useModalsStore} from "@/admin/inertia/modules/modals"
import {onMounted, onUnmounted, Ref, ref} from 'vue'
import axios from "axios"
import {useProfileStore} from "@/admin/inertia/modules/profile"
import {Toasts, useToastsStore} from "@/admin/inertia/modules/toasts"


const modalsStore = useModalsStore()
const toastsStore = useToastsStore()
const profileStore = useProfileStore()

const resizer = ref<Ref<Element>>(null)
const sidebar = ref<Ref<{element: Ref<Element>}>>(null)
const isClicked = ref<boolean>(false)

const resize = (event) => {
    if (!isClicked.value) {
        return
    }

    profileStore.setAdminSidebarFlexBasis(event.x)
    if (window.getSelection && window.getSelection().empty) {
        // Chrome
        window.getSelection().empty()
        return
    }

    if (window.getSelection && window.getSelection().removeAllRanges) {
        // Firefox
        window.getSelection().removeAllRanges()
        return
    }

    // @ts-ignore
    if (document.selection) {
        // IE?
        // @ts-ignore
        document.selection.empty()
    }
}
const onMouseUpCB = async () => {
    if (!isClicked.value) {
        return
    }

    isClicked.value = false

    try {
        let {data: {settings : {adminSidebarFlexBasis}}} = await axios.put<{
            settings: {
                adminSidebarFlexBasis: string|number
            }
        }>(`/admin-ajax/profiles/1`, {
            adminSidebarFlexBasis: `${profileStore.adminSidebarFlexBasis}px`,
        })

        profileStore.setAdminSidebarFlexBasis(adminSidebarFlexBasis)
    } catch (e) {
        console.warn(e.message)
    }
}

onMounted(() => {
    document.addEventListener("mousemove", resize, false)
    document.addEventListener("mouseup", onMouseUpCB,false)
})

onUnmounted(() => {
    document.removeEventListener('mousemove', resize)
    document.removeEventListener('mouseup', onMouseUpCB)
})
</script>

<template>
    <div id="wrapper" class="wrapper">
        <TheHeader />
        <main class="d-flex">
            <div id="resize-container" class="">
                <TheSidebar ref="sidebar" />
                <div @mousedown="isClicked = true" ref="resizer" id="resizer"></div>
                <div class="" id="content">
                    <slot></slot>
                </div>
            </div>
        </main>
        <component
            v-for="(modal, idx) in modalsStore.types"
            :is="Modals[modal.type]"
            :type="modal.type"
            :modal-props="modal.props || {}"
            :key="`${modal.type}-${idx}`"
        />
        <div v-if="toastsStore.types.length" class="toast-container position-fixed bottom-0 end-0 p-3">
            <template v-for="(toast, idx) in toastsStore.types" :key="`${toast.props._uuid}`">
                <component
                    :is="Toasts[toast.type]"
                    :type="toast.type"
                    :toast-props="toast.props"
                />
            </template>
        </div>
    </div>
</template>
