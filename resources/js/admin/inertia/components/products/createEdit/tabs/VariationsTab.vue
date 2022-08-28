<script lang="ts" setup>
import {useModalsStore, ModalType} from "@/admin/inertia/modules/modals"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"
import {useField, useFieldArray, Field, FieldEntry} from "vee-validate"
import {getEmptyVariation} from "@/admin/inertia/modules/forms/createEditProduct"
import {useColumnsStore, isSortableColumn, ColumnName} from "@/admin/inertia/modules/columns"
import {ref, watch} from "vue"
import {VariationForm} from "@/admin/inertia/modules/forms/createEditProduct/types"
import {randomId} from "@/admin/inertia/utils"
import Media from "@/admin/inertia/modules/common/Media"
import {copyMedia} from "@/admin/inertia/modules/common/utils"
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"


const modalsStore = useModalsStore()
const columnsStore = useColumnsStore()
const currenciesStore = useCurrenciesStore()
const availabilitiesStore = useAvailabilityStatusesStore()

const {setValue} = useField<Array<VariationForm>>('variations')
const {fields, push, update, remove} = useFieldArray<VariationForm>('variations')
const selectAll = ref<boolean>(false)
const editMode = ref<boolean>(false)
const onAddVariation = () => {
    push(getEmptyVariation())
    modalsStore.openModal(ModalType.CREATE_EDIT_VARIATION, {})
}
const onEditVariation = (idx: number) => {
    modalsStore.openModal(ModalType.CREATE_EDIT_VARIATION, {
        index: idx
    })
}
watch(selectAll, (nv) => {
    let allVariations = fields.value.map(field => ({
        ...field.value,
        is_checked: !!nv
    }))

    setValue(allVariations)
})
const toggleActive = (variation: FieldEntry<VariationForm>, idx: number) => {
    update(idx, {
        ...variation.value,
        is_active: !variation.value.is_active,
    })
}
const copyVariation = async (variation: FieldEntry<VariationForm>) => {
    let mainImage = await copyMedia(variation.value.mainImage)
    let additionalImages: Array<Media> = []
    for (const image of variation.value.additionalImages) {
        additionalImages = [
            ...additionalImages,
            await copyMedia(image)
        ]
    }
    push({
        ...variation.value,
        id: null,
        uuid: randomId(),
        mainImage,
        additionalImages,
    })
}
const saveVariations = () => {

}
const cancelVariations = () => {

}
const deleteProduct = (variation: FieldEntry<VariationForm>, idx: number) => {
    if (confirm(`Вы уверены, что хотите удалить вариант товара ${variation.value.id} ${variation.value.name} ?'`)) {
        remove(idx)
    }
}

const deleteSelected = () => {
    if (confirm('Вы уверены, что хотите удалить отмеченные записи?')) {

    }
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
                                    <button @click="onEditVariation(idx)" type="button" class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Изменить</span>
                                    </button>
                                    <button @click="toggleActive(product, idx)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon"></span>
                                        <span class="bx-core-popup-menu-item-text"> {{ product.value.is_active ? 'Деактивировать' : 'Активировать' }}</span>
                                    </button>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="copyVariation(product)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                        <span class="bx-core-popup-menu-item-text">Копировать</span>
                                    </button>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="deleteProduct(product, idx)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <template v-for="sortableColumn in columnsStore.adminProductVariantColumns" :key="sortableColumn.value">
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.id)">
                                <span class="main-grid-cell-content">{{product.value.id}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.name)">
                                <span class="main-grid-cell-content">{{product.value.name}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.active)">
                                <span class="main-grid-cell-content">{{product.value.is_active ? 'Да' : 'Нет'}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.detailed_image)">
                                <a v-if="product.value.mainImage" :href="product.value.mainImage.url" target="_blank">
                                    <img class="img-fluid" :src="product.value.mainImage.url" alt="">
                                </a>
                                <template v-else>
                                    &nbsp;
                                </template>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.additional_images)">
                                <div v-for="image in product.value.additionalImages" :key="image.uuid" class="mb-2" style="max-width: 40px">
                                    <a :href="image.url" target="_blank">
                                        <img class="img-fluid" :src="image.url" alt="">
                                    </a>
                                </div>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.ordering)">
                                <span class="main-grid-cell-content">{{product.value.ordering}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.price_purchase)">
                                <span class="main-grid-cell-content">
                                    {{ currenciesStore.priceFormatted(product.value.price_purchase, product.value.price_purchase_currency_id) }}
                                </span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.price_retail)">
                                <span class="main-grid-cell-content">
                                    {{ currenciesStore.priceFormatted(product.value.price_retail, product.value.price_retail_currency_id) }}
                                </span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.unit)">
                                <span class="main-grid-cell-content">{{product.value.unit}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.coefficient)">
                                <span class="main-grid-cell-content">{{product.value.coefficient}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.coefficient_description)">
                                <span class="main-grid-cell-content">{{product.value.coefficient_description}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.availability)">
                                <span class="main-grid-cell-content">{{availabilitiesStore.formattedName(product.value.availability_status_id)}}</span>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="admin-edit-variations__footer">
            <div v-if="editMode" class="variants-btn-group" role="group" aria-label="actions">
                <button
                    aria-label="edit all mode"
                    type="button"
                    class="btn brn-edit"></button>
                <button
                    @click="deleteSelected"
                    aria-label="delete all"
                    type="button"
                    class="btn btn-delete"></button>
            </div>
            <template v-else>
                <button
                    @click="saveVariations"
                    type="button"
                    class="btn btn-light"
                >Сохранить</button>
                <button
                    @click="cancelVariations"
                    type="button"
                    class="btn btn-light"
                >Отменить</button>
            </template>
        </div>
    </div>
</template>
