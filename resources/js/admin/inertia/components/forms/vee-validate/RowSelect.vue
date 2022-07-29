<script lang="ts" setup>
import { Field } from 'vee-validate'
import Option from "@/admin/inertia/modules/common/Option"


const props = defineProps<{
    name: string
    label: string
    options: Array<Option>
    keepValue?: boolean
}>()
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="props.name">{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <Field
                v-slot="{field, meta}"
                :name="props.name"
                :keep-value="props.keepValue"
            >
                <select
                    :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '' ]"
                    :id="props.name"
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
        </div>
    </div>
</template>
