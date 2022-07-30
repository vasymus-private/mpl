<script lang="ts" setup>
import {useModalsStore, ModalType} from "@/admin/inertia/modules/modals"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"
import {useFieldArray} from "vee-validate"
import {getEmptyVariation} from "@/admin/inertia/modules/forms/createEditProduct"
import {Variation} from "@/admin/inertia/modules/products/Product"


const modalsStore = useModalsStore()
const {push} = useFieldArray<Variation>('variations')
const onAddVariation = () => {
    push(getEmptyVariation())
    modalsStore.openModal(ModalType.CREATE_EDIT_VARIATION, {})
}
</script>

<template>
    <div class="admin-edit-variations">
        <div class="admin-edit-variations__header">
            <button type="button" @click="onAddVariation" class="btn btn__add">Добавить элемент</button>
            <button type="button" @click="modalsStore.openModal(ModalType.SORT_ADMIN_COLUMNS, {type: ColumnType.adminProductColumns})" class="btn btn-primary mb-2 mr-2">Настроить</button>
        </div>
    </div>
</template>
