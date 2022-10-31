<script setup lang="ts">
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"
import {computed, defineAsyncComponent, onBeforeUnmount, ref} from "vue"
import ModalCloseButton from '@/admin/inertia/components/modals/ModalCloseButton.vue'
import {useFieldArray, Field, useField, FieldEntry} from "vee-validate"
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowInputSelect from '@/admin/inertia/components/forms/vee-validate/RowInputSelect.vue'
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import RowImage from '@/admin/inertia/components/forms/vee-validate/RowImage.vue'
import RowImages from '@/admin/inertia/components/forms/vee-validate/RowImages.vue'
import {VariationForm} from "@/admin/inertia/modules/forms/createEditProduct/types"
import {useMounted} from "@vueuse/core"


const isMounted = useMounted()
const AppHtmlEditor = defineAsyncComponent(() => import('@/admin/inertia/components/forms/parts/AppHtmlEditor.vue'))

const props = defineProps<{
    type: ModalType
    modalProps?: {
        index?: number
    }
}>()

const availabilityStatusesStore = useAvailabilityStatusesStore()
const currenciesStore = useCurrenciesStore()
const modalsStore = useModalsStore()
const routesStore = useRoutesStore()

const {setValue} = useField<Array<VariationForm>>('variations')
const {fields, remove} = useFieldArray<VariationForm>('variations')

const index = typeof props?.modalProps?.index !== 'undefined'
    ? props.modalProps.index
    : fields.value.length - 1

const field = computed(() => fields.value[index].value)

const isEditingVariation = computed<boolean>((): boolean => field.value.id !== null)
const initialName = field.value.name

const title = computed(
    () => isEditingVariation.value
        ? `Многовариантные товары ${initialName} - Редактирование`
        : `Многовариантные товары (добавление)`
)
const uploadUrl = computed(() => {
    return isEditingVariation.value
        ? routesStore.route(routeNames.ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD, {admin_product: field.value.id})
        : null
})

const {setValue: setPreviewValue} = useField(`variations[${index}].preview`)
const preview = computed({
    get() {
        return field.value.preview || null
    },
    set(nv) {
        return setPreviewValue(nv)
    }
})

const toSave = ref<boolean>(false)
const sortVariations = () => {
    let variations = fields.value.map((variation: FieldEntry<VariationForm>) => variation.value)
    let sorted = variations.sort((a: VariationForm, b: VariationForm) => a.ordering - b.ordering)
    setValue(sorted)
}
const save = () => {
    sortVariations()
    toSave.value = true
    modalsStore.closeModal(ModalType.CREATE_EDIT_VARIATION)
}
onBeforeUnmount(() => {
    if (toSave.value) {
        return
    }
    if (isEditingVariation.value) {
        return;
    }
    remove(index)
})
</script>

<template>
    <Modal :type="props.type" class="modal-xl">
        <template #title>
            <h5 class="modal-title" :id="`label-${props.type}`">{{ title }}</h5>
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
                        <RowCheckbox
                            :name="`variations[${index}].is_active`"
                            label="Активность"
                            :keep-value="true"
                        />

                        <RowInput
                            :name="`variations[${index}].name`"
                            label="Название"
                            label-class="fw-bold"
                            :keep-value="true"
                        />

                        <RowInput
                            :name="`variations[${index}].ordering`"
                            label="Сортировка"
                            type="number"
                            :keep-value="true"
                        />

                        <RowInput
                            :name="`variations[${index}].coefficient`"
                            label="Коэффициент на единицу расхода и единица расхода"
                            type="number"
                            :keep-value="true"
                        />

                        <RowInput
                            :name="`variations[${index}].coefficient_description`"
                            label="Описание коэффициента"
                            :keep-value="true"
                        />

                        <RowInput
                            :name="`variations[${index}].unit`"
                            label="Упаковка / Единица"
                            :keep-value="true"
                        />

                        <RowSelect
                            :name="`variations[${index}].availability_status_id`"
                            label="Наличие"
                            :options="availabilityStatusesStore.optionsFormatted"
                            :keep-value="true"
                        />

                        <RowInputSelect
                            label-input="Закупочная цена"
                            :name-input="`variations[${index}].price_purchase`"
                            label-input-class="fw-bold"
                            type-input="number"
                            label-select="Валюта"
                            :name-select="`variations[${index}].price_purchase_currency_id`"
                            label-select-class="fw-bold"
                            :options="currenciesStore.options"
                            :keep-value="true"
                        />

                        <RowInputSelect
                            label-input="Розничная цена"
                            :name-input="`variations[${index}].price_retail`"
                            label-input-class="fw-bold"
                            type-input="number"
                            label-select="Валюта"
                            :name-select="`variations[${index}].price_retail_currency_id`"
                            label-select-class="fw-bold"
                            :options="currenciesStore.options"
                            :keep-value="true"
                        />

                        <div class="h6">Описание для анонса</div>

                        <ul class="nav nav-tabs item-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="create-variation-html-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#create-variation-html-content"
                                    type="button"
                                    role="tab"
                                    aria-controls="create-variation-html-content"
                                    aria-selected="true"
                                >HTML</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link active"
                                    id="create-variation-editor-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#create-variation-editor-content"
                                    type="button"
                                    role="tab"
                                    aria-controls="create-variation-editor-content"
                                    aria-selected="false"
                                >Визуальный редактор</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div
                                class="tab-pane p-3 fade"
                                id="create-variation-html-content"
                                role="tabpanel"
                                aria-labelledby="create-variation-html-tab"
                            >
                                <Field
                                    v-slot="{field, meta}"
                                    :name="`variations[${index}].preview`"
                                    :keep-value="true"
                                >
                                    <textarea
                                        v-bind="field"
                                        :class="['form-control', 'h-100', !meta.valid ? 'is-invalid' : '']"
                                        :id="`variations[${index}].preview`"
                                        rows="3"
                                    />
                                </Field>
                            </div>
                            <div
                                class="tab-pane p-3 fade show active"
                                id="create-variation-editor-content"
                                role="tabpanel"
                                aria-labelledby="create-variation-editor-tab"
                            >
                                <AppHtmlEditor
                                    v-if="isMounted"
                                    v-model="preview"
                                    :upload-url="uploadUrl"
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        class="tab-pane item-edit product-edit p-3 fade"
                        id="create-variation-photo-content"
                        role="tabpanel"
                        aria-labelledby="create-variation-photo-tab"
                    >
                        <RowImage
                            :name="`variations[${index}].mainImage`"
                            label="Основное фото"
                            :keep-value="true"
                        />

                        <RowImages
                            :name="`variations[${index}].additionalImages`"
                            label="Дополнительные фото"
                            :keep-value="true"
                        />
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
