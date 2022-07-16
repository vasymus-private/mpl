<script lang="ts" setup>
import FormGroupCheckBox from '@/admin/inertia/components/forms/vee-validate/FormGroupCheckBox.vue'
import FormGroupInput from '@/admin/inertia/components/forms/vee-validate/FormGroupInput.vue'

</script>

<template>
    <div class="item-edit product-edit">
        <FormGroupCheckBox name="is_active" label="Активность" />
        <FormGroupInput name="name" label="Название" />
    </div>
</template>
