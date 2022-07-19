<script lang="ts" setup>
import {AnyObjectSchema, AnySchema} from "yup"
import {toRef} from "vue"
import {useField} from "vee-validate"
import Option from "@/admin/inertia/modules/common/Option"


const props = defineProps<{
    name: string
    label: string
    options: Array<Option>
    nullOption?: boolean
    isNotRow?: boolean
    rules?: AnySchema | AnyObjectSchema | undefined
    placeholder?: string
    inputColClass?: string
}>()
const nameRef = toRef(props, 'name')
let { errorMessage, value } = useField(nameRef, props.rules)
</script>

<template>
    <div :class="['form-group', !props.isNotRow ? 'row' : '']">
        <label :for="`id-${props.name}`" class="col-sm-5 col-form-label">{{props.label}}:</label>
        <div :class="['col-sm-7', 'd-flex', 'align-items-center', props.inputColClass || '']">
            <select
                v-model="value"
                :class="['form-control', errorMessage ? 'is-invalid' : '' ]"
                :id="`id-${props.name}`"
                @blur="$emit('blur')"
            >
                <option v-if="props.nullOption" :value="undefined">{{props.placeholder || '(не установлено)'}}</option>
                <option
                    v-for="option in props.options"
                    :key="option.value"
                    :value="option.value"
                    :disabled="option.disabled"
                >{{option.label}}</option>
            </select>
            <div v-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
        </div>
    </div>
</template>
