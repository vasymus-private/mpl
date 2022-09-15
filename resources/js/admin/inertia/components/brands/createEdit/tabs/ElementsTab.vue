<script lang="ts" setup>
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'
</script>

<template>
    <div class="item-edit product-edit">
        <NameAndSlug />

        <RowInput
            name="ordering"
            label="Сортировка"
            type="number"
        />
    </div>
</template>
