<script lang="ts" setup>
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import {toRef} from "vue"


const props = defineProps<{
    name: string
    label: string
    labelClass?: string|object|Array<string>
    type?: 'text' | 'number'
    keepValue?: boolean
}>()
const name = toRef(props, 'name')
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="name" :class="props.labelClass">{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <FormControlInput
                :name="name"
                :type="props.type"
                :keep-value="props.keepValue"
            />
        </div>
    </div>
</template>
