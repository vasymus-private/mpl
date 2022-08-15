<script lang="ts" setup>
import { Field } from 'vee-validate'
import {toRef} from "vue"


const props = defineProps<{
    name: string
    rows?: number
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
        <textarea
            v-bind="field"
            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
            :id="name"
            :rows="props.rows || 3"
        />
    </Field>
</template>
