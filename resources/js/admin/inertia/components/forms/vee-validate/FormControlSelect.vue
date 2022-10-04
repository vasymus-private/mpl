<script lang="ts" setup>
import { Field } from 'vee-validate'
import Option from "@/admin/inertia/modules/common/Option"
import {toRef} from "vue"


const props = defineProps<{
    name: string
    options: Array<Option>
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
        <select
            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '' ]"
            :id="name"
            v-bind="field"
        >
            <option :value="undefined">(не установлено)</option>
            <option
                v-for="option in props.options"
                :key="option.value"
                :value="option.value"
                :disabled="option.disabled"
            >{{option.label}}</option>
        </select>
    </Field>
</template>
