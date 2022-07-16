<script lang="ts" setup>
import {Link} from "@inertiajs/inertia-vue3"


defineProps<{
    idOrHref: string
    isInertiaLink: boolean
    title: string
    iconClass: string
    isCollapse: boolean
    isActiveCollapse?: boolean
    isArrowSpace?: boolean
    navLinkClass?: string
}>()
</script>

<template>
    <li class="nav-item">
        <component
            :is="isInertiaLink ? Link : 'a'"
            :href="idOrHref"
            :class="['nav-link', navLinkClass || '', isCollapse && !isActiveCollapse ? 'collapsed' : '']"
            :data-bs-toggle="isCollapse ? 'collapse' : null"
            :data-bs-target="isCollapse ? `#${idOrHref}` : null"
            :aria-expanded="!isCollapse ? null : (isCollapse && isActiveCollapse ? 'true' : 'false')"
            :aria-controls="!isCollapse ? null : idOrHref"
        >
            <span v-if="isCollapse" class="adm-arrow-icon"></span>
            <span v-if="isArrowSpace" style="width: 20px;"></span>
            <span :class="iconClass"></span>
            <span class="nav-link-text">{{ title }}</span>
        </component>
        <ul v-if="isCollapse" :id="idOrHref" :class="['nav', 'collapse', isActiveCollapse ? 'show' : '']">
            <slot />
        </ul>
    </li>
</template>
