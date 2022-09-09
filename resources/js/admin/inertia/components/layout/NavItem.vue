<script lang="ts" setup>
import {Link} from "@inertiajs/inertia-vue3"
import {Inertia} from "@inertiajs/inertia"
import {onMounted, onUnmounted, ref} from "vue"
import {Collapse} from "bootstrap"


const props = defineProps<{
    idOrHref: string
    isInertiaLink: boolean
    title: string
    iconClass: string
    isCollapse: boolean
    isActiveCollapse?: boolean
    isArrowSpace?: boolean
    navLinkClass?: string
    navLinkTextHref?: string
}>()

const collapse = ref<HTMLElement>(null)
const linkText = ref<HTMLElement>(null)
const toShow = ref<boolean|null>(null)
let notPreventCollapsing = ref<boolean>(false)

const handleCollapse = (event) => {
    if (!props.isCollapse) {
        return
    }

    if (!props.navLinkTextHref || event.target !== linkText.value) {
        handleToggleCollapse()
        return
    }

    Inertia.visit(props.navLinkTextHref)
}

const handleToggleCollapse = () => {
    if (!collapse.value) {
        return
    }

    let instance = Collapse.getInstance(collapse.value)
    if (!instance) {
        return
    }

    if (toShow.value == null) {
        return
    }

    notPreventCollapsing.value = true

    if (toShow.value) {
        instance.show()
    } else {
        instance.hide()
    }
}

const getCollapseListener = (isShow: boolean) => event => {
    event.stopPropagation()

    if (notPreventCollapsing.value) {
        return true
    }
    toShow.value = isShow
    event.preventDefault()
}

const onCollapseEnd = () => {
    notPreventCollapsing.value = false
}

onMounted(() => {
    if (!collapse.value || !props.navLinkTextHref) {
        return
    }

    collapse.value.addEventListener('show.bs.collapse', getCollapseListener(true))
    collapse.value.addEventListener('shown.bs.collapse', onCollapseEnd)

    collapse.value.addEventListener('hide.bs.collapse', getCollapseListener(false))
    collapse.value.addEventListener('hidden.bs.collapse', onCollapseEnd)
})

onUnmounted(() => {
    if (!collapse.value || !props.navLinkTextHref) {
        return
    }

    collapse.value.removeEventListener('show.bs.collapse', getCollapseListener(true))
    collapse.value.removeEventListener('shown.bs.collapse', onCollapseEnd)

    collapse.value.removeEventListener('hide.bs.collapse', getCollapseListener(false))
    collapse.value.removeEventListener('hidden.bs.collapse', onCollapseEnd)
})
</script>

<template>
    <li class="nav-item">
        <component
            :is="props.isInertiaLink ? Link : 'a'"
            :href="props.idOrHref"
            :class="['nav-link', props.navLinkClass || '', props.isCollapse && !props.isActiveCollapse ? 'collapsed' : '']"
            :data-bs-toggle="props.isCollapse ? 'collapse' : null"
            :data-bs-target="props.isCollapse ? `#${props.idOrHref}` : null"
            :aria-expanded="!props.isCollapse ? null : (props.isCollapse && props.isActiveCollapse ? 'true' : 'false')"
            :aria-controls="!props.isCollapse ? null : props.idOrHref"
            @click="handleCollapse"
        >
            <span v-if="props.isCollapse" class="adm-arrow-icon"></span>
            <span v-if="props.isArrowSpace" style="width: 20px;"></span>
            <span :class="props.iconClass"></span>
            <span ref="linkText" class="nav-link-text">{{ title }}</span>
        </component>
        <ul
            v-if="props.isCollapse"
            :id="props.idOrHref"
            :class="['nav', 'collapse', props.isActiveCollapse ? 'show' : '']"
            ref="collapse"
        >
            <slot />
        </ul>
    </li>
</template>
