<script lang="ts" setup>
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"


const props = defineProps<{
    type: ModalType
    label?: string
}>()
const modalsStore = useModalsStore()
</script>

<template>
    <button
        type="button"
        class="btn btn-secondary"
        @click="modalsStore.closeModal(props.type)"
    >{{props.label || 'Закрыть'}}</button>
</template>
