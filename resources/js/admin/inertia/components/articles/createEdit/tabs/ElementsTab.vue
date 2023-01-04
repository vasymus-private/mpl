<script lang="ts" setup>
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import {useArticlesStore} from "@/admin/inertia/modules/articles"

const articlesStore = useArticlesStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!articlesStore.isCreatingArticleRoute" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ articlesStore.article?.id }}
            </div>
        </div>

        <RowCheckbox name="is_active" label="Активность" />

        <NameAndSlug />

        <RowSelect name="parent_id" label="Родительская статья" :options="articlesStore.optionsWithoutEntity" />
    </div>
</template>
