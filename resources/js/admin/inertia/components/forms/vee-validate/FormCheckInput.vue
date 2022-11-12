<script lang="ts" setup>
import { Field } from 'vee-validate'
import {toRef} from "vue"


const props = defineProps<{
    name: string
    keepValue?: boolean
}>()
const name = toRef(props, 'name')
</script>

<template>
    <Field
        v-slot="{ field, meta }"
        :name="name"
        type="checkbox"
        :value="true"
        :keep-value="props.keepValue"
    >
        <input
            v-bind="field"
            :name="name"
            type="checkbox"
            :value="true"
            :id="name"
            :class="['form-check-input', !meta.valid && meta.touched ? 'is-invalid' : '']"
        />
    </Field>
</template>
