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
const classObj = computed(() => ({'page-item': true, 'disabled': !props.link.URL}))
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
    'type': string|null
    'href': string|null
} => {
    return {
        'aria-hidden': ariaHiddenLinkLike.value,
        'aria-label': ariaLabelLinkLike.value,
        'type': props.emitOnPage ? 'button' : null,
        'href': props.emitOnPage || isNotLink.value ? null : props.link.url
    }
})
const linkLikeComponent = computed((): string|typeof Link => {
    return props.emitOnPage
        ? 'button'
        : (
            isNotLink.value
                ? 'span'
                : Link
        )
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
        <component :is="linkLikeComponent" v-bind="linkLikeAttrs" v-html="linkContent" />
        <span class="page-link" aria-hidden="true">&lsaquo;</span>
        <span class="page-link" aria-hidden="true">&rsaquo;</span>
        <Link :href="props.link.url" class="page-link" aria-label="Предыдущая">&lsaquo;</Link>
        <Link :href="props.link.url" class="page-link" aria-label="Следующая">&rsaquo;</Link>
    </li>
</template>
