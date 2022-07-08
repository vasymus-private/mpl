<script lang="ts" setup>
import {Teleport, ref, onMounted, onUnmounted} from "vue"
import {Modal} from 'bootstrap'
import ModalCloseButton from "@/admin/inertia/components/modals/ModalCloseButton.vue"
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"


const props = defineProps<{
    type: ModalType
    title?: string
}>()
const modalsStore = useModalsStore()
const modal = ref(null)
let bootstrapModal
onMounted(() => {
    bootstrapModal = new Modal(modal.value)
    modal.value.addEventListener('hide.bs.modal', () => {
        modalsStore.closeModal(props.type)
    })
    bootstrapModal.show()
})
onUnmounted(() => {
    bootstrapModal.hide()
    bootstrapModal.dispose()
})
</script>

<template>
    <Teleport to="body">
        <div ref="modal" class="modal fade" :id="props.type" tabindex="-1" :aria-labelledby="`label-${props.type}`" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="title">
                            <h5 v-if="props.title" class="modal-title" :id="`label-${props.type}`">{{props.title}}</h5>
                        </slot>
                        <button @click="modalsStore.closeModal(props.type)" type="button" class="btn-close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <ModalCloseButton :type="props.type" />
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
