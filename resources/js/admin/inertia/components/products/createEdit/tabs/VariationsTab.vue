<script lang="ts" setup>
import {useModalsStore, ModalType} from "@/admin/inertia/modules/modals"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"
import {useField, useFieldArray, Field, FieldEntry} from "vee-validate"
import {getEmptyVariation} from "@/admin/inertia/modules/forms/createEditProduct"
import {useColumnsStore} from "@/admin/inertia/modules/columns"
import {ref, watch} from "vue"
import {VariationForm} from "@/admin/inertia/modules/forms/createEditProduct/interfaces"


const modalsStore = useModalsStore()
const columnsStore = useColumnsStore()
const {setValue} = useField<Array<VariationForm>>('variations')
const {fields, push, } = useFieldArray<VariationForm>('variations')
const selectAll = ref<boolean>(false)
const editMode = ref<boolean>(false)
const onAddVariation = () => {
    push(getEmptyVariation())
    modalsStore.openModal(ModalType.CREATE_EDIT_VARIATION, {})
}
watch(selectAll, (nv) => {
    let allVariations = fields.value.map(field => ({
        ...field.value,
        is_checked: !!nv
    }))

    setValue(allVariations)
})
const toggleActive = (variation: FieldEntry<VariationForm>) => {

}
const copyVariation = (variation: FieldEntry<VariationForm>) => {

}
const deleteProduct = (variation: FieldEntry<VariationForm>) => {

}
</script>

<template>
    <div class="admin-edit-variations">
        <div class="admin-edit-variations__header">
            <button type="button" @click="onAddVariation" class="btn btn__add">Добавить элемент</button>
            <button type="button" @click="modalsStore.openModal(ModalType.SORT_ADMIN_COLUMNS, {type: ColumnType.adminProductVariantColumns})" class="btn btn-primary mb-2 mr-2">Настроить</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="form-check form-check-inline">
                            <input
                                :disabled="editMode"
                                v-model="selectAll"
                                class="form-check-input position-static"
                                type="checkbox">
                        </div>
                    </th>
                    <th scope="col">&nbsp;</th>
                    <th v-for="sortableColumn in columnsStore.adminProductVariantColumns" :key="sortableColumn.value" scope="col">{{sortableColumn.label}}</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, idx) in fields" :key="product.value.uuid">
                        <td>
                            <div class="form-check">
                                <Field
                                    v-slot="{ field, meta }"
                                    :name="`variations[${idx}].is_checked`"
                                    type="checkbox"
                                    :value="true"
                                >
                                    <input
                                        v-bind="field"
                                        :name="`variations[${idx}].is_checked`"
                                        type="checkbox"
                                        :value="true"
                                        class="form-check-input position-static"
                                    />
                                </Field>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button
                                    class="btn btn__grid-row-action-button dropdown-toggle"
                                    type="button"
                                    :id="`actions-dropdown-${product.value.uuid}`"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                ></button>
                                <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${product.value.uuid}`">
                                    <div class="bx-core-popup-menu__arrow"></div>
                                    <button type="button" class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Изменить</span>
                                    </button>
                                    <button @click="toggleActive(product)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon"></span>
                                        <span class="bx-core-popup-menu-item-text"> {{ product.value.is_active ? 'Деактивировать' : 'Активировать' }}</span>
                                    </button>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="copyVariation(product)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                        <span class="bx-core-popup-menu-item-text">Копировать</span>
                                    </button>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="deleteProduct(product)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
