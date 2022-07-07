<script lang="ts" setup>
import {Teleport} from "vue"
import ModalCloseButton from "@/admin/inertia/components/modals/ModalCloseButton.vue"


const props = defineProps<{
    id: string
    title?: string
}>()
</script>

<template>
    <Teleport to="body">
        <div class="modal fade" :id="props.id" tabindex="-1" :aria-labelledby="`label-${props.id}`" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="title">
                            <h5 v-if="props.title" class="modal-title" :id="`label-${props.id}`">{{props.title}}</h5>
                        </slot>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <ModalCloseButton />
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
