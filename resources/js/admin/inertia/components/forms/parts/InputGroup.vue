<script setup lang="ts">
import {randomId} from "@/admin/inertia/utils"

const props = defineProps<{
    modelValue?: string | null
    placeholder?: string | null
}>()
const emits = defineEmits(['update:modelValue', 'click'])
const id = randomId()
</script>

<template>
    <div class="input-group mb-3">
        <input
            type="text"
            class="form-control"
            :placeholder="props.placeholder"
            :value="props.modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :aria-label="props.placeholder"
            :aria-describedby="id"
        >
        <button
            class="btn btn-outline-secondary"
            type="button"
            :id="id"
            @click="$emit('click')"
        ><i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
</template>
