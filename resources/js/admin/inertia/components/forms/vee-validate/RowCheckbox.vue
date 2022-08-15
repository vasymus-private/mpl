<script lang="ts" setup>
import FormCheckInput from '@/admin/inertia/components/forms/vee-validate/FormCheckInput.vue'
import {toRef} from "vue"


const props = defineProps<{
    name: string
    label: string
    keepValue?: boolean
}>()
const name = toRef(props, 'name')
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="name">{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <FormCheckInput :name="name" :keep-value="props.keepValue" />
        </div>
    </div>
</template>
