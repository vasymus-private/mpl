<script setup lang="ts">
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"
import {computed, onBeforeUnmount, ref} from "vue"
import {isCreatingProductRoute} from "@/admin/inertia/modules/products"
import ModalCloseButton from '@/admin/inertia/components/modals/ModalCloseButton.vue'
import {useFieldArray} from "vee-validate"
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowInputSelect from '@/admin/inertia/components/forms/vee-validate/RowInputSelect.vue'
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"


const props = defineProps<{
    type: ModalType
    modalProps?: object
}>()
const availabilityStatusesStore = useAvailabilityStatusesStore()
const currenciesStore = useCurrenciesStore()
const toSave = ref<boolean>(false)
const isCreating = computed(() => isCreatingProductRoute())
const {fields, remove} = useFieldArray('variations')
const modalsStore = useModalsStore()
const lastIndex = fields.value.length - 1
const save = () => {
    toSave.value = true
    modalsStore.closeModal(ModalType.CREATE_EDIT_VARIATION)
}

onBeforeUnmount(() => {
    if (toSave.value) {
        return
    }
    remove(lastIndex)
})
</script>

<template>
    <Modal :type="props.type" class="modal-xl">
        <template #title>
            <h5 class="modal-title" :id="`label-${props.type}`"></h5>
        </template>

        <template #default>
            <div>
                <ul class="nav nav-tabs item-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="create-variation-element-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#create-variation-element-content"
                            type="button"
                            role="tab"
                            aria-controls="create-variation-element-content"
                            aria-selected="true"
                        >Элемент</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="create-variation-photo-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#create-variation-photo-content"
                            type="button"
                            role="tab"
                            aria-controls="create-variation-photo-content"
                            aria-selected="false"
                        >Фото</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div
                        class="tab-pane p-3 item-edit product-edit fade show active"
                        id="create-variation-element-content"
                        role="tabpanel"
                        aria-labelledby="create-variation-element-tab"
                    >
                        <RowCheckbox :name="`variations[${lastIndex}].is_active`" label="Активность" />

                        <RowInput :name="`variations[${lastIndex}].name`" label="Название" label-class="fw-bold" />

                        <RowInput :name="`variations[${lastIndex}].ordering`" label="Сортировка" type="number" />

                        <RowInput :name="`variations[${lastIndex}].coefficient`" label="Коэффициент на единицу расхода и единица расхода" type="number" />

                        <RowInput :name="`variations[${lastIndex}].coefficient_description`" label="Описание коэффициента" />

                        <RowInput :name="`variations[${lastIndex}].unit`" label="Упаковка / Единица" />

                        <RowSelect
                            :name="`variations[${lastIndex}].availability_status_id`"
                            label="Наличие"
                            :options="availabilityStatusesStore.optionsFormatted"
                        />

                        <RowInputSelect
                            label-input="Закупочная цена"
                            name-input="price_purchase"
                            label-input-class="fw-bold"
                            type-input="number"
                            label-select="Валюта"
                            name-select="price_purchase_currency_id"
                            label-select-class="fw-bold"
                            :options="currenciesStore.options"
                        />
                    </div>
                    <div
                        class="tab-pane item-edit product-edit p-3 fade"
                        id="create-variation-photo-content"
                        role="tabpanel"
                        aria-labelledby="create-variation-photo-tab"
                    >
                        фото
                    </div>
                </div>
            </div>
        </template>

        <template #footer>
            <button @click="save" type="button" class="btn btn-primary">Сохранить</button>
            <ModalCloseButton :type="props.type" />
        </template>
    </Modal>
</template>
