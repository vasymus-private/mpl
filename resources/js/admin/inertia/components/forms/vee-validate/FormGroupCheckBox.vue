<script lang="ts" setup>
import {toRef} from 'vue'
import { useField } from 'vee-validate'
import {AnyObjectSchema, AnySchema} from 'yup'


const props = defineProps<{
    name: string
    label: string
    id?: string
    rules?: AnySchema | AnyObjectSchema | undefined
}>()
const nameRef = toRef(props, 'name')
const { errorMessage, value } = useField(nameRef, props.rules)
</script>

<template>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="form-check-label" :for="`id-${props.name}`">{{props.label}}:</label>
        </div>
        <div class="col-sm-7">
            <div :class="['form-check', errorMessage ? 'is-invalid' : '']">
                <input v-model="value" :id="`id-${props.name}`" class="form-check-input" type="checkbox">
            </div>
            <div v-if="errorMessage" class="invalid-feedback mt-4">{{ errorMessage }}</div>
        </div>
    </div>
</template>
