<script lang="ts" setup>
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {computed, ref, Ref} from "vue"
import {Column, ColumnType} from "@/admin/inertia/modules/columns/types"
import {useColumnsStore} from "@/admin/inertia/modules/columns"
import Draggable from 'vuedraggable'
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"
import ModalCloseButton from '@/admin/inertia/components/modals/ModalCloseButton.vue'


const props = defineProps<{
    type: ModalType
    modalProps: {
        type: ColumnType
    }
}>()
const columnsStore = useColumnsStore()
const _columns: Ref<Array<Column>> = ref([])
const columns = computed({
    get(): Array<Column> {
        if (_columns.value.length) {
            return _columns.value
        }
        return getFromStore()
    },
    set(columns: Array<Column>): void {
        _columns.value = columns
    }
})
const getFromStore = () => {
    switch (props.modalProps.type) {
        case ColumnType.adminProductColumns: {
            return columnsStore.adminProductColumns
        }
        case ColumnType.adminOrderColumns: {
            return columnsStore.adminOrderColumns
        }
        case ColumnType.adminProductVariantColumns: {
            return columnsStore.adminProductVariantColumns
        }
        default: {
            return []
        }
    }
}
const modalsStore = useModalsStore()
const handleSet = async () => {
    let payload
    switch (props.modalProps.type) {
        case ColumnType.adminProductColumns: {
            payload = {adminProductColumns: _columns.value.map((column: Column) => column.value)}
            break
        }
        case ColumnType.adminOrderColumns: {
            payload = {adminOrderColumns: _columns.value.map((column: Column) => column.value)}
            break
        }
        case ColumnType.adminProductVariantColumns: {
            payload = {adminProductVariantColumns: _columns.value.map((column: Column) => column.value)}
            break
        }
        default: {
            return
        }
    }
    await columnsStore.handleSortColumns(payload)
    _columns.value = getFromStore()
    modalsStore.closeModal(props.type)
}
const handleDefault = async () => {
    let payload
    switch (props.modalProps.type) {
        case ColumnType.adminOrderColumns: {
            payload = {adminOrderColumnsDefault: true}
            break
        }
        case ColumnType.adminProductColumns: {
            payload = {adminProductColumnsDefault: true}
            break
        }
        case ColumnType.adminProductVariantColumns: {
            payload = {adminProductVariantColumnsDefault: true}
            break
        }
        default: {
            return
        }
    }
    await columnsStore.handleSortColumns(payload)
    _columns.value = getFromStore()
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
