<script lang="ts" setup>
import {Option} from "@/admin/inertia/modules/common/types"
import FormControlSelect from '@/admin/inertia/components/forms/vee-validate/FormControlSelect.vue'
import {toRef} from "vue"


const props = defineProps<{
    name: string
    label: string
    options: Array<Option>
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
            <FormControlSelect :name="name" :keep-value="props.keepValue" :options="props.options" />
        </div>
    </div>
</template>
