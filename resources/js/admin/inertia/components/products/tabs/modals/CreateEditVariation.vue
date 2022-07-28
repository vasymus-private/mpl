<script setup lang="ts">
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"
import {computed, onBeforeUnmount, ref} from "vue"
import {isCreatingProductRoute} from "@/admin/inertia/modules/products"
import ModalCloseButton from '@/admin/inertia/components/modals/ModalCloseButton.vue'
import {useFieldArray} from "vee-validate"
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'


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
    <Modal :type="props.type" class="modal-xl">
        <template #title>
            <h5 class="modal-title" :id="`label-${props.type}`"></h5>
        </template>

        <template #default>
            <div>
                <ul class="nav nav-tabs item-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="create-variation-element-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#create-variation-element-content"
                            type="button"
                            role="tab"
                            aria-controls="create-variation-element-content"
                            aria-selected="true"
                        >Элемент</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="create-variation-photo-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#create-variation-photo-content"
                            type="button"
                            role="tab"
                            aria-controls="create-variation-photo-content"
                            aria-selected="false"
                        >Фото</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div
                        class="tab-pane p-3 fade show active"
                        id="create-variation-element-content"
                        role="tabpanel"
                        aria-labelledby="create-variation-element-tab"
                    >
                        <RowCheckbox :name="`variations[${lastIndex}].is_active`" label="Активность" />
                    </div>
                    <div
                        class="tab-pane p-3 fade"
                        id="create-variation-photo-content"
                        role="tabpanel"
                        aria-labelledby="create-variation-photo-tab"
                    >
                        фото
                    </div>
                </div>
            </div>
        </template>

        <template #footer>
            <button @click="save" type="button" class="btn btn-primary">Сохранить</button>
            <ModalCloseButton :type="props.type" />
        </template>
    </Modal>
</template>
