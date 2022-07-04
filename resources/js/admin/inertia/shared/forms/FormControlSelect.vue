<script lang="ts" setup>
import {defineProps, defineEmits, computed} from "vue"
import Option from "@/admin/inertia/modules/common/Option"
import { useVModel } from '@vueuse/core'


const props = defineProps<{
    modelValue: string|number
    class?: string
    label?: string
    id?: string
    nullOption?: boolean
    placeholder?: string
    options: Array<Option>
    errors?: Array<string>
}>()
const emit = defineEmits(['update:modelValue'])
const data = useVModel(props, 'modelValue', emit)
const hasErrors = computed(() => props.errors && props.errors.length)
</script>

<template>
    <div :class="props.class">
        <label
            v-if="props.label"
            :for="props.id"
            class="form-label"
        >{{ props.label }}</label>
        <select v-model="data" :class="['form-select', hasErrors && 'is-invalid']" :id="props.id">
            <option
                v-if="props.nullOption"
                selected
                disabled
                value=""
            >{{ props.placeholder || '(не установлено)' }}</option>
            <option v-for="option in props.options" :key="option.value" :value="option.value">{{option.label}}</option>
        </select>
        <template v-if="hasErrors">
            <div v-for="error in props.errors" :key="error" class="invalid-feedback">
                {{ error }}
            </div>
        </template>

    </div>
</template>
