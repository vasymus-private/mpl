<script lang="ts" setup>
import {toRef} from 'vue'
import { useField } from 'vee-validate'
import {AnyObjectSchema, AnySchema} from 'yup'


const props = defineProps<{
    name: string
    label: string
    isNotRow?: boolean
    rules?: AnySchema | AnyObjectSchema | undefined
    labelClass?: string
    labelColClass?: string
    inputColClass?: string
    inputGroup?: boolean
}>()
const nameRef = toRef(props, 'name')
let { errorMessage, value } = useField(nameRef, props.rules)

const emit = defineEmits(['input'])
</script>

<template>
    <div :class="['form-group', props.isNotRow ? '' : 'row']">
        <label
            :for="`id-${props.name}`"
            :class="[props.labelClass, props.isNotRow ? 'form-label' : (props.labelColClass || 'col-form-label col-sm-5')]"
        >{{props.label}}:</label>
        <component :is="props.isNotRow ? 'span' : 'div'" :class="[props.isNotRow ? '' : (props.inputColClass || 'col-sm-7')]">
            <component :is="props.inputGroup ? 'div' : 'span'" :class="['input-group', props.inputGroup && errorMessage ? 'is-invalid' : '']">
                <input
                    v-model="value"
                    type="text"
                    :class="['form-control', errorMessage ? 'is-invalid' : '']"
                    :id="`id-${props.name}`"
                    @blur="$emit('blur')"
                />
                <slot v-if="props.inputGroup" name="input-group-append"></slot>
            </component>
            <div v-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
        </component>
    </div>
</template>
