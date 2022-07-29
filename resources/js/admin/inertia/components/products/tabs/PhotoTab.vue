<script lang="ts" setup>
import RowImage from '@/admin/inertia/components/forms/vee-validate/RowImage.vue'
import RowImages from '@/admin/inertia/components/forms/vee-validate/RowImages.vue'
</script>

<template>
    <div class="item-edit product-edit">
        <RowImage name="mainImage" label="Основное фото" />

        <RowImages name="additionalImages" label="Дополнительные фото" />
    </div>
</template>
