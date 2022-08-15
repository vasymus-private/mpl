<script lang="ts" setup>
import {Field} from "vee-validate"
import {toRef} from "vue"


const props = defineProps<{
    label1: string
    name1: string
    type1?: 'text' | 'number'
    label2: string
    name2: string
    type2?: 'text' | 'number'
    sizes?: [number, number, number, number]
}>()
const name1 = toRef(props, 'name1')
const name2 = toRef(props, 'name2')
</script>

<template>
    <div class="row mb-3">
        <div :class="['text-end', `col-sm-${(props.sizes && props.sizes[0]) || 5}`]">
            <label :for="name1">{{ props.label1 }}:</label>
        </div>
        <div :class="[`col-sm-${(props.sizes && props.sizes[1]) || 2}`]">
            <Field
                v-slot="{field, meta}"
                :name="name1"
            >
                <input
                    v-bind="field"
                    :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                    :type="props.type1 || 'text'"
                    :id="name1"
                />
            </Field>
        </div>
        <div :class="['text-end', `col-sm-${(props.sizes && props.sizes[2]) || 2}`]">
            <label :for="name2">{{ props.label2 }}:</label>
        </div>
        <div :class="[`col-sm-${(props.sizes && props.sizes[3]) || 3}`]">
            <Field
                v-slot="{field, meta}"
                :name="name2"
            >
                <input
                    v-bind="field"
                    :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                    :type="props.type2 || 'text'"
                    :id="name2"
                />
            </Field>
        </div>
    </div>
</template>
