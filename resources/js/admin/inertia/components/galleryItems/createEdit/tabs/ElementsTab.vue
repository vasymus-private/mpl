<script lang="ts" setup>
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import {useGalleryItemsStore} from "@/admin/inertia/modules/galleryItems"

const galleryItemsStore = useGalleryItemsStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!galleryItemsStore.isCreatingGalleryItemRoute" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ galleryItemsStore.article?.id }}
            </div>
        </div>

        <RowCheckbox name="is_active" label="Активность" />

        <NameAndSlug />

        <RowSelect name="parent_id" label="Родительская статья" :options="galleryItemsStore.optionsWithoutEntity" />
    </div>
</template>
