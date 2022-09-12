<script lang="ts" setup>
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import {useCreateEditCategoryFormStore} from "@/admin/inertia/modules/forms/createEditCategory"
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'
import Description from "@/admin/inertia/components/forms/parts/Description.vue"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {computed} from "vue"
import {getRouteUrl, routeNames} from "@/admin/inertia/modules/routes"


const createEditCategoryFormStore = useCreateEditCategoryFormStore()
const categoriesStore = useCategoriesStore()
const uploadUrl = computed(() => {
    return categoriesStore.category?.id
        ? getRouteUrl(routeNames.ROUTE_ADMIN_AJAX_CATEGORY_IMAGE_UPLOAD, {admin_category: categoriesStore.category?.id})
        : null
})
</script>

<template>
    <div class="item-edit product-edit">
        <RowCheckbox
            name="is_active"
            label="Активность"
        />

        <RowSelect
            name="parent_id"
            label="Родительский раздел"
            :options="createEditCategoryFormStore.parentCategoryOptions"
        />

        <NameAndSlug />

        <RowInput
            name="ordering"
            label="Сортировка"
            type="number"
        />

        <Description
            id="description"
            label="Детальное описание"
            name="description"
            :upload-url="uploadUrl"
        />
    </div>
</template>
