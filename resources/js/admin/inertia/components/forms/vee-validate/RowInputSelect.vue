<script setup lang="ts">
import {Option} from "@/admin/inertia/modules/common/types"
import { Field } from 'vee-validate'
import {toRef} from "vue"


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
const nameInput = toRef(props, 'nameInput')
const nameSelect = toRef(props, 'nameSelect')
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="nameInput" :class="props.labelInputClass">{{ props.labelInput }}:</label>
        </div>
        <div class="col-sm-2">
            <Field
                v-slot="{field, meta}"
                :name="nameInput"
                :keep-value="props.keepValue"
            >
                <input
                    v-bind="field"
                    :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                    :type="props.typeInput || 'text'"
                    :id="nameInput"
                />
            </Field>
        </div>
        <div class="col-sm-3 text-end">
            <label :for="nameSelect" :class="props.labelSelectClass">{{ props.labelSelect }}:</label>
        </div>
        <div class="col-sm-2">
            <Field
                v-slot="{field, meta}"
                :name="nameSelect"
                :keep-value="props.keepValue"
            >
                <select
                    :class="['form-control', !meta.valid ? 'is-invalid' : '' ]"
                    :id="nameSelect"
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
