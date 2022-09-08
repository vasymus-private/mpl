<script lang="ts" setup>
import {Link} from "@inertiajs/inertia-vue3"


const props = defineProps<{
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
            :is="props.isInertiaLink ? Link : 'a'"
            :href="props.idOrHref"
            :class="['nav-link', props.navLinkClass || '', props.isCollapse && !props.isActiveCollapse ? 'collapsed' : '']"
            :data-bs-toggle="props.isCollapse ? 'collapse' : null"
            :data-bs-target="props.isCollapse ? `#${props.idOrHref}` : null"
            :aria-expanded="!props.isCollapse ? null : (props.isCollapse && props.isActiveCollapse ? 'true' : 'false')"
            :aria-controls="!props.isCollapse ? null : props.idOrHref"
        >
            <span v-if="props.isCollapse" class="adm-arrow-icon"></span>
            <span v-if="props.isArrowSpace" style="width: 20px;"></span>
            <span :class="props.iconClass"></span>
            <span class="nav-link-text">{{ title }}</span>
        </component>
        <ul
            v-if="props.isCollapse"
            :id="props.idOrHref"
            :class="['nav', 'collapse', props.isActiveCollapse ? 'show' : '']"
        >
            <slot />
        </ul>
    </li>
</template>
