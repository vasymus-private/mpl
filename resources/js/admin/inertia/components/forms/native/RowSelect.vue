<script lang="ts" setup>
import {Option} from "@/admin/inertia/modules/common/types"


const props = defineProps<{
    name: string
    label: string
    modelValue?: Option|null
    options: Array<Option>
}>()
const emit = defineEmits(['update:modelValue'])

const onInput = (event) => {
    emit('update:modelValue', props.options[event.target.selectedIndex])
}
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="props.name">{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <select @input="onInput" class="form-select">
                <option
                    v-for="option in props.options"
                    :key="option.value"
                    :value="option"
                    :selected="props.modelValue && props.modelValue.value === option.value"
                >{{option.label}}</option>
            </select>
        </div>
    </div>
</template>
