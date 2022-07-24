<script lang="ts" setup>
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import RowTextarea from '@/admin/inertia/components/forms/vee-validate/RowTextarea.vue'

</script>

<template>
    <div class="item-edit product-edit">
        <RowInput name="seo.title" label="Заголовок окна браузера" />

        <RowInput name="seo.h1" label="Заголовок страницы (h1)" />

        <RowTextarea name="seo.keywords" label="Meta Keywords" />

        <RowTextarea name="seo.description" label="Meta Description" />
    </div>
</template>
