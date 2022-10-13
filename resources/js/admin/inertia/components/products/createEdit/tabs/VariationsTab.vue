<script lang="ts" setup>
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"
import {ColumnType, ColumnName} from "@/admin/inertia/modules/columns/types"
import {useField, useFieldArray, FieldEntry} from "vee-validate"
import {getEmptyVariation} from "@/admin/inertia/modules/forms/createEditProduct"
import {useColumnsStore, isSortableColumn} from "@/admin/inertia/modules/columns"
import {VariationForm} from "@/admin/inertia/modules/forms/createEditProduct/types"
import {randomId} from "@/admin/inertia/utils"
import {Media} from "@/admin/inertia/modules/common/types"
import {copyMedia} from "@/admin/inertia/modules/common/utils"
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {Variation} from "@/admin/inertia/modules/products/types"
import {useProductsStore} from "@/admin/inertia/modules/products"
import {storeToRefs} from "pinia"


const modalsStore = useModalsStore()
const columnsStore = useColumnsStore()
const currenciesStore = useCurrenciesStore()
const availabilitiesStore = useAvailabilityStatusesStore()
const productsStore = useProductsStore()

const {setValue} = useField<Array<VariationForm>>('variations')
const {fields, push, update, remove} = useFieldArray<VariationForm>('variations')

const {variations} = storeToRefs(productsStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<Variation>(variations)

const onAddVariation = () => {
    push(getEmptyVariation())
    modalsStore.openModal(ModalType.CREATE_EDIT_VARIATION, {})
}
const onEditVariation = (idx: number) => {
    modalsStore.openModal(ModalType.CREATE_EDIT_VARIATION, {
        index: idx
    })
}

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

watchSelectAll()
</script>

<template>
    <div class="admin-edit-variations">
        <div class="admin-edit-variations__header">
            <button type="button" @click="onAddVariation" class="btn btn__add">Добавить элемент</button>
            <button type="button" @click="modalsStore.openModal(ModalType.SORT_ADMIN_COLUMNS, {type: ColumnType.adminProductVariantColumns})" class="btn btn-primary mb-2 me-2">Настроить</button>
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
                    <tr v-for="(product, idx) in fields" :key="product.value.uuid" @click="manualCheck(product.value.uuid)">
                        <td>
                            <div class="form-check">
                                <input
                                    :disabled="editMode"
                                    v-model="checkedItems"
                                    :value="product.value.uuid"
                                    class="form-check-input position-static js-product-item-checkbox"
                                    type="checkbox"
                                    @click.stop=""
                                />
                            </div>
                        </td>
                        <td>
                            <div class="dropdown" @click.stop="">
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
                        <template v-for="(sortableColumn, idx) in columnsStore.adminProductVariantColumns" :key="sortableColumn.value">
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.id)">
                                <span class="main-grid-cell-content">{{product.value.id}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.name)">
                                <FormControlInput v-if="editMode" :name="`variations[${idx}].name`" />
                                <span v-else class="main-grid-cell-content">{{product.value.name}}</span>
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
            <div v-if="!editMode" class="variants-btn-group" role="group" aria-label="actions">
                <button
                    aria-label="edit all mode"
                    type="button"
                    @click="editMode = true"
                    :disabled="!checkedItems.length"
                    class="btn brn-edit"></button>
                <button
                    @click="deleteSelected"
                    :disabled="!checkedItems.length"
                    aria-label="delete all"
                    type="button"
                    class="btn btn-delete"></button>
            </div>
            <template v-else>
                <button
                    @click="saveVariations"
                    type="button"
                    class="btn btn-light"
                >Ок</button>
                <button
                    @click="cancelVariations"
                    type="button"
                    class="btn btn-light"
                >Отменить</button>
            </template>
        </div>
    </div>
</template>
