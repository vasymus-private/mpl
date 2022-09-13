<script lang="ts" setup>
import {Teleport, ref, onMounted, onBeforeUnmount} from "vue"
import {Modal} from 'bootstrap'
import ModalCloseButton from "@/admin/inertia/components/modals/ModalCloseButton.vue"
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"


const props = defineProps<{
    type: ModalType
    title?: string
}>()
const modalsStore = useModalsStore()
const modal = ref(null)
let bootstrapModal = ref<Modal>(null)
onMounted(() => {
    bootstrapModal.value = new Modal(modal.value)
    modal.value.addEventListener('hidden.bs.modal', () => {
        modalsStore.closeModal(props.type)
        bootstrapModal.value.dispose()
    })
    bootstrapModal.value.show()
})
onBeforeUnmount(() => {
    bootstrapModal.value.hide()
})
defineExpose({
    bootstrapModal
})
</script>

<template>
    <Teleport to="body">
        <div ref="modal" class="modal fade" :id="props.type" tabindex="-1" :aria-labelledby="`label-${props.type}`" aria-hidden="true">
            <div class="modal-dialog" :class="$attrs.class">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="title">
                            <h5 v-if="props.title" class="modal-title" :id="`label-${props.type}`">{{props.title}}</h5>
                        </slot>
                        <button @click="modalsStore.closeModal(props.type)" type="button" class="btn-close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <slot />
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
