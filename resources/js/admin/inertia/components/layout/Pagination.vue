<script lang="ts" setup>
import {computed} from 'vue'
import FormControlSelect from '@/admin/inertia/components/forms/parts/FormControlSelect.vue'
import Option from "@/admin/inertia/modules/common/Option"
import { useVModel } from '@vueuse/core'
import {MetaLink} from "@/admin/inertia/modules/common/Meta"
import PageItem from "@/admin/inertia/components/layout/PageItem.vue"


const props = defineProps<{
    total: number
    currentPage: number
    perPageOptions: Array<Option>
    perPage: Option
    links: Array<MetaLink>
    emitOnPage?: boolean
    sizes?: Array<number>
}>()

const lastPage = computed((): number => Math.max(Math.ceil(props.total / +props.perPage.value), 1))

const emit = defineEmits(['update:perPage'])
const perPageData = useVModel(props, 'perPage', emit)
</script>

<template>
    <div class="block-pagination">
        <div class="row">
            <div :class="`col-sm-${props.sizes ? props.sizes[0] : 10} row-line`">
                <span class="block-pagination__text">Всего: {{props.total}}</span>
                <div>
                    <nav>
                        <ul class="pagination">
                            <PageItem
                                v-for="link in props.links"
                                :key="link.label"
                                :link="link"
                                :last-page="lastPage"
                                :current-page="props.currentPage"
                                :emit-on-page="props.emitOnPage"
                                @update:page="(p) => $emit('update:page', p)"
                            />
                        </ul>
                    </nav>
                </div>
            </div>
            <div :class="`col-sm-${props.sizes ? props.sizes[1] : 2}`">
                <FormControlSelect
                    v-model="perPageData"
                    class="form-group row"
                    label="На странице:"
                    :options="perPageOptions"
                />
            </div>
        </div>
    </div>
</template>
