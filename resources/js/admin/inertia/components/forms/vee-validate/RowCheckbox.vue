<script lang="ts" setup>
import { Field } from 'vee-validate'


const props = defineProps<{
    name: string
    label: string
}>()
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="props.name">{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <Field
                v-slot="{ field, meta }"
                :name="props.name"
                type="checkbox"
                :value="true"
            >
                <input
                    v-bind="field"
                    :name="props.name"
                    type="checkbox"
                    :value="true"
                    :id="props.name"
                    :class="['form-check-input', !meta.valid && meta.touched ? 'is-invalid' : '']"
                />
            </Field>
        </div>
    </div>
</template>
