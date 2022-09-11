<script lang="ts" setup>
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import {useCreateEditCategoryFormStore} from "@/admin/inertia/modules/forms/createEditCategory"
import DescriptionField from '@/admin/inertia/components/categories/createEdit/parts/DescriptionField.vue'
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'

const createEditCategoryFormStore = useCreateEditCategoryFormStore()
</script>

<template>
    <div class="item-edit product-edit">
        <RowCheckbox name="is_active" label="Активность" />

        <RowSelect name="parent_id" label="Родительский раздел" :options="createEditCategoryFormStore.parentCategoryOptions" />

        <NameAndSlug />

        <RowInput name="ordering" label="Сортировка" type="number" />

        <DescriptionField />
    </div>
</template>
