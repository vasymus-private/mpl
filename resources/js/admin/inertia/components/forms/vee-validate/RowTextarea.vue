<script lang="ts" setup>
import { Field } from 'vee-validate'


const props = defineProps<{
    name: string
    label: string
    rows?: number
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
                <textarea
                    v-bind="field"
                    :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                    :id="props.name"
                    :rows="props.rows || 3"
                />
            </Field>
        </div>
    </div>
</template>
