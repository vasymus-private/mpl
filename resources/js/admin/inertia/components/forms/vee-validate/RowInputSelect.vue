<script setup lang="ts">
import Option from "@/admin/inertia/modules/common/Option"
import { Field } from 'vee-validate'

const props = defineProps<{
    labelInput: string
    nameInput: string
    typeInput?: 'text' | 'number'
    labelInputClass?: string|object|Array<string>
    labelSelect: string
    nameSelect: string
    labelSelectClass?: string|object|Array<string>
    options: Array<Option>
    keepValue?: boolean
}>()
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="props.nameInput" :class="props.labelInputClass">{{ props.labelInput }}:</label>
        </div>
        <div class="col-sm-2">
            <Field
                v-slot="{field, meta}"
                :name="props.nameInput"
                :keep-value="props.keepValue"
            >
                <input
                    v-bind="field"
                    :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                    :type="props.typeInput || 'text'"
                    :id="props.nameInput"
                />
            </Field>
        </div>
        <div class="col-sm-3 text-end">
            <label :for="props.nameSelect" :class="props.labelSelectClass">{{ props.labelSelect }}:</label>
        </div>
        <div class="col-sm-2">
            <Field
                v-slot="{field, meta}"
                :name="props.nameSelect"
                :keep-value="props.keepValue"
            >
                <select
                    :class="['form-control', !meta.valid ? 'is-invalid' : '' ]"
                    :id="props.nameSelect"
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
