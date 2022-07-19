<script lang="ts" setup>
import {toRef} from 'vue'
import { useField } from 'vee-validate'
import {AnyObjectSchema, AnySchema} from 'yup'


const props = defineProps<{
    name: string
    label: string
    isNotRow?: boolean
    rules?: AnySchema | AnyObjectSchema | undefined
    labelClass?: string
    labelColClass?: string
    inputColClass?: string
    inputGroup?: boolean
}>()
const nameRef = toRef(props, 'name')
let { errorMessage, value } = useField(nameRef, props.rules)

const emit = defineEmits(['input'])
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label :for="props.name" :class="props.labelClass">{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <input
                v-model="value"
                :class="['form-control', errorMessage ? 'is-invalid' : '']"
                type="text"
                @blur="$emit('blur')"
                :id="`id-${props.name}`"
            />
            <div v-if="props.inputGroup" class="input-group-append">
                <button
                    @click="generateSlugSyncMode = !generateSlugSyncMode"
                    class="btn btn-outline-secondary"
                    type="button"
                ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</template>
