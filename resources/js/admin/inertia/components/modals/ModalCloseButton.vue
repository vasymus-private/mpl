<script lang="ts" setup>
const props = defineProps<{
    label?: string
}>()
</script>

<template>
    <button
        type="button"
        class="btn btn-secondary"
        data-bs-dismiss="modal"
        @click="$emit('click')"
    >{{props.label || 'Закрыть'}}</button>
</template>
