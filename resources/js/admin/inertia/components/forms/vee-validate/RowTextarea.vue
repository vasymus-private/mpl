<script lang="ts" setup>
import FormControlTextarea from '@/admin/inertia/components/forms/vee-validate/FormControlTextarea.vue'
import {toRef} from "vue"


const props = defineProps<{
    name: string
    label: string
    rows?: number
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
            <FormControlTextarea :name="name" :rows="rows" :keep-value="props.keepValue" />
        </div>
    </div>
</template>
