<script lang="ts" setup>
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'
import {useBrandsStore} from "@/admin/inertia/modules/brands"


const brandsStore = useBrandsStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!brandsStore.isCreatingBrandRoute" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ brandsStore.brand?.id }}
            </div>
        </div>

        <NameAndSlug />

        <RowInput
            name="ordering"
            label="Сортировка"
            type="number"
        />
    </div>
</template>
