<script lang="ts" setup>
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"


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
