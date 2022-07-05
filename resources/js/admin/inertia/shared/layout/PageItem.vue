<script lang="ts" setup>
import {defineProps, computed} from "vue"
import {MetaLink} from "@/admin/inertia/modules/common/Meta"
import {Link} from "@inertiajs/inertia-vue3"


const props = defineProps<{
    link: MetaLink
    currentPage: number
    lastPage: number
    emitOnPage?: boolean
}>()
const classObj = computed(() => ({'page-item': true, 'disabled': !props.link.url}))
const onFirstPage = computed(() => props.currentPage === 1)
const hasMorePages = computed(() => props.currentPage < props.lastPage)

const isPageNumber = computed(() => !props.link.isPrev && !props.link.isNext && !props.link.isSeparator)

const ariaDisabledListItem = computed((): string|null => {
    if (props.link.isSeparator) {
        return 'true'
    }

    if (props.link.isPrev && onFirstPage.value) {
        return 'true'
    }

    if (props.link.isNext && !hasMorePages.value) {
        return 'true'
    }

    return null
})
const ariaLabelListItem = computed((): string|null => {
    if (props.link.isPrev && onFirstPage.value) {
        return 'Предыдущая'
    }

    if (props.link.isNext && !hasMorePages.value) {
        return 'Следующая'
    }

    return null
})
const ariaCurrentListItem = computed((): string|null => {
    if (isPageNumber.value && props.link.page === props.currentPage) {
        return 'page'
    }

    return null
})
const ariaLabelLinkLike = computed((): string|null => {
    if (props.link.isPrev && !onFirstPage.value) {
        return 'Предыдущая'
    }

    if (props.link.isNext && hasMorePages.value) {
        return 'Следующая'
    }

    return null
})
const ariaHiddenLinkLike = computed((): string|null => {
    if (props.link.isPrev && onFirstPage.value) {
        return 'true'
    }

    if (props.link.isNext && !hasMorePages.value) {
        return 'true'
    }

    return null
})
const listItemAttrs = computed((): {
    'aria-disabled': string|null
    'aria-label': string|null
    'aria-current': string|null
} => {
    return {
        'aria-disabled': ariaDisabledListItem.value,
        'aria-label': ariaLabelListItem.value,
        'aria-current': ariaCurrentListItem.value,
    }
})
const isNotLink = computed((): boolean => (props.link.isPrev && onFirstPage.value) || (props.link.isSeparator) || (props.link.isNext && !hasMorePages.value) || (isPageNumber.value && props.link.page === props.currentPage))

const linkLikeAttrs = computed((): {
    'aria-hidden': string|null
    'aria-label': string|null
} => {
    return {
        'aria-hidden': ariaHiddenLinkLike.value,
        'aria-label': ariaLabelLinkLike.value,
    }
})
const linkContent = computed((): string|number => {
    if (props.link.isPrev) {
        return '&lsaquo;'
    }
    if (props.link.isNext) {
        return '&rsaquo;'
    }
    if (props.link.isSeparator) {
        return '...'
    }

    return +props.link.page
})
</script>

<template>
    <li :class="classObj" v-bind="listItemAttrs">
        <span v-if="isNotLink" v-bind="linkLikeAttrs" v-html="linkContent" />
        <button v-else-if="!isNotLink && props.emitOnPage" v-bind="linkLikeAttrs" type="button" @click="$emit('onPage', props.link.page)" v-html="linkContent" />
        <Link v-else :href="props.link.url" v-bind="linkLikeAttrs" v-html="linkContent" />
    </li>
</template>
