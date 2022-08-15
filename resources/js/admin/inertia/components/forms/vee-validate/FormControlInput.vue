<script lang="ts" setup>
import { Field } from 'vee-validate'
import {toRef} from "vue"


const props = defineProps<{
    name: string
    type?: 'text' | 'number'
    keepValue?: boolean
}>()
const name = toRef(props, 'name')
</script>

<template>
    <Field
        v-slot="{field, meta}"
        :name="name"
        :keep-value="props.keepValue"
    >
        <input
            v-bind="field"
            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
            :type="props.type || 'text'"
            :id="name"
        />
    </Field>
</template>
