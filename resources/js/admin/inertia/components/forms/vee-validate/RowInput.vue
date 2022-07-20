<script lang="ts" setup>
import { Field } from 'vee-validate'


const props = defineProps<{
    name: string
    label: string
    type?: string
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
            >
                <input
                    v-bind="field"
                    :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                    :type="props.type || 'text'"
                    :id="props.name"
                />
            </Field>
        </div>
    </div>
</template>
