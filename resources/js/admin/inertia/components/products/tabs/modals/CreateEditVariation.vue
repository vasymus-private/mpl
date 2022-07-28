<script setup lang="ts">
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"
import {computed, onBeforeUnmount, ref} from "vue"
import {isCreatingProductRoute} from "@/admin/inertia/modules/products"
import ModalCloseButton from '@/admin/inertia/components/modals/ModalCloseButton.vue'
import {useFieldArray} from "vee-validate"


const props = defineProps<{
    type: ModalType
    modalProps?: object
}>()
const toSave = ref<boolean>(false)
const isCreating = computed(() => isCreatingProductRoute())
const {fields, remove} = useFieldArray('variations')
const modalsStore = useModalsStore()
const lastIndex = fields.value.length - 1
const save = () => {
    toSave.value = true
    modalsStore.closeModal(ModalType.CREATE_EDIT_VARIATION)
}

onBeforeUnmount(() => {
    if (toSave.value) {
        return
    }
    remove(lastIndex)
})
</script>

<template>
    <Modal :type="props.type">
        <template #title>
            <h5 class="modal-title" :id="`label-${props.type}`"></h5>
        </template>

        <template>

        </template>

        <template #footer>
            <button @click="save" type="button" class="btn btn-primary">Сохранить</button>
            <ModalCloseButton :type="props.type" />
        </template>
    </Modal>
</template>
