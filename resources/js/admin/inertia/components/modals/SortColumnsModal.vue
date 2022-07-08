<script lang="ts" setup>
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {computed, ref, Ref} from "vue"
import Column from "@/admin/inertia/modules/columns/Column"
import {useColumnsStore} from "@/admin/inertia/modules/columns"
import Draggable from 'vuedraggable'
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"
import ModalCloseButton from '@/admin/inertia/components/modals/ModalCloseButton.vue'


const props = defineProps<{
    type: ModalType
}>()
const columnsStore = useColumnsStore()
const _columns: Ref<Array<Column>> = ref([])
const columns = computed({
    get(): Array<Column> {
        return _columns.value.length ? _columns.value : columnsStore.adminProductColumns
    },
    set(columns: Array<Column>): void {
        _columns.value = columns
    }
})
const modalsStore = useModalsStore()
const handleSet = async () => {
    await columnsStore.handleSortColumns({adminProductColumns: _columns.value.map((column: Column) => column.value)})
    _columns.value = columnsStore.adminProductColumns
    modalsStore.closeModal(props.type)
}
const handleDefault = async () => {
    await columnsStore.handleSortColumns({adminProductColumnsDefault: true})
    _columns.value = columnsStore.adminProductColumns
    modalsStore.closeModal(props.type)
}
</script>

<template>
    <Modal :type="props.type" title="Настройка списка">
        <div class="card">
            <draggable
                v-model="columns"
                group="people"
                item-key="value">
                <template #item="{element}">
                    <div class="list-group-item">{{element.label}}</div>
                </template>
            </draggable>
        </div>
        <template #footer>
            <button
                type="button"
                class="btn btn-primary"
                @click="handleSet"
            >Сохранить</button>
            <ModalCloseButton
                :type="props.type"
                label="Отменить"
            />
            <button
                type="button"
                class="btn btn-secondary"
                @click="handleDefault"
            >Сбросить</button>
        </template>
    </Modal>
</template>
