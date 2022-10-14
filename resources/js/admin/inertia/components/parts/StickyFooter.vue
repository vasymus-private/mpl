<script setup lang="ts">
import {onMounted, onUnmounted, ref, watch} from 'vue'
import {getElementSizeWithoutPadding, getOffSet, getWindowScrollTop, getWindowSize} from "@/admin/inertia/utils/dom"
import {useRoutesStore} from "@/admin/inertia/modules/routes"
import {storeToRefs} from 'pinia'


const routesStore = useRoutesStore()

const {activeTabUrlParam} = storeToRefs(routesStore)

const isPinned = ref<boolean>(true)
const isVisible = ref<boolean>(false)
const marker = ref<HTMLDivElement>(null)
const footer = ref<HTMLDivElement>(null)


const adjust = (): void => {
    if (!isPinned.value) {
        return
    }

    isVisible.value = getIsVisible()
}

const getIsVisible = (): boolean => {
    let footerTop = getOffSet(marker.value).top
    let scrollTop = getWindowScrollTop()

    let space = getWindowSize().height - getElementSizeWithoutPadding(footer.value).height

    let compare = scrollTop + space + 20

    return footerTop < compare
}

onMounted(() => {
    adjust()
    window.addEventListener('scroll', adjust)
})
onUnmounted(() => {
    window.removeEventListener('scroll', adjust)
})
watch(activeTabUrlParam, () => {
    adjust()
})
</script>

<template>
    <div class="js-edit-footer-wrapper">
        <div ref="marker" class="js-edit-item-footer-marker"></div>
        <div ref="footer" :class="['edit-item-footer', 'js-edit-item-footer', isPinned && !isVisible ? 'edit-item-footer-fixed' : '']">
            <slot />
            <button @click="isPinned = !isPinned" type="button" :class="['btn', 'btn-info', 'js-pin-btn', 'pin-btn', isPinned ? 'pin-btn-pinned' : '']"></button>
        </div>
    </div>
</template>
