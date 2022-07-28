<script lang="ts" setup>
import {useModalsStore, ModalType} from "@/admin/inertia/modules/modals"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"
import {useFieldArray} from "vee-validate"
import {randomId} from "@/admin/inertia/utils"

const modalsStore = useModalsStore()
const {push} = useFieldArray('variations')
const onAddVariation = () => {
    push({
        id: null,
        uuid: randomId(),
        is_active: false,
        name: null,
        ordering: 500,
        coefficient: null,
        coefficient_description: null,
        price_purchase: null,
        price_purchase_currency_id: null,
        price_retail: null,
        price_retail_currency_id: null,
        unit: null,
        availability_status_id: null,
        preview: null,
        mainImage: null,
        additionalImages: [],
    })
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
