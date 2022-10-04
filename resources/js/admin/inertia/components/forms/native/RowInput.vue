<script lang="ts" setup>
const props = defineProps<{
    name: string
    label: string
    modelValue?: string | null
    type?: 'text' | 'number' | 'date'
}>()
const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="props.name">{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <input
                class="form-control"
                :type="props.type || 'text'"
                :id="props.name"
                :value="props.modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
    </div>
</template>
