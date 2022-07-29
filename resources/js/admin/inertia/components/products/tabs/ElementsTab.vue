<script lang="ts" setup>
import {isCreatingProductRoute, useProductsStore} from "@/admin/inertia/modules/products"
import {computed, ref, watch} from "vue"
import {slugify} from "@/admin/inertia/modules/common"
import {useFormsStore} from "@/admin/inertia/modules/forms"
import {useBrandsStore} from "@/admin/inertia/modules/brands"
import { Field } from 'vee-validate'
import InfoPrices from "@/admin/inertia/components/products/tabs/forms/InfoPrices.vue"
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowInputSelect from '@/admin/inertia/components/forms/vee-validate/RowInputSelect.vue'
import RowTextarea from '@/admin/inertia/components/forms/vee-validate/RowTextarea.vue'
import Instructions from "@/admin/inertia/components/products/tabs/forms/Instructions.vue"
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"


const productsStore = useProductsStore()
const formsStore = useFormsStore()
const brandsStore = useBrandsStore()
const currenciesStore = useCurrenciesStore()
const availabilityStatusesStore = useAvailabilityStatusesStore()

const isCreating = computed(() => isCreatingProductRoute())
const generateSlugSyncMode = ref(false)

watch(generateSlugSyncMode, newV => {
    if (newV) {
        handleSyncNameAndSlug()
    }
})
const handleSyncNameAndSlug = async () => {
    if (!generateSlugSyncMode.value) {
        return
    }

    if (!formsStore.product.name) {
        return
    }

    productsStore.updateProduct({
        slug: await slugify(formsStore.product.name)
    })
}
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!isCreating" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ productsStore.product?.id }}
            </div>
        </div>

        <RowCheckbox name="is_active" label="Активность" />

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="name" class="fw-bold">Название:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="name"
                >
                    <div :class="['input-group', !meta.valid && meta.touched ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
                            type="text"
                            id="name"
                            @blur="handleSyncNameAndSlug"
                        />
                        <div class="input-group-append">
                            <button
                                @click="generateSlugSyncMode = !generateSlugSyncMode"
                                class="btn btn-outline-secondary"
                                type="button"
                            ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="slug" class="fw-bold">Символьный код:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="slug"
                >
                    <div :class="['input-group', !meta.valid && meta.touched ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
                            type="text"
                            id="slug"
                        />
                        <div class="input-group-append">
                            <button
                                @click="generateSlugSyncMode = !generateSlugSyncMode"
                                class="btn btn-outline-secondary"
                                type="button"
                            ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </Field>
            </div>
        </div>

        <RowInput name="ordering" label="Сортировка" type="number" />

        <RowSelect name="brand_id" label="Производитель" :options="brandsStore.options" />

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="coefficient">Коэффициент на единицу расхода:</label>
            </div>
            <div class="col-sm-1">
                <Field
                    v-slot="{field, meta}"
                    name="coefficient"
                >
                    <input
                        v-bind="field"
                        :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                        type="number"
                        id="coefficient"
                    />
                </Field>
            </div>
            <div class="col-sm-3 text-end">
                <label for="coefficient_description">Описание коэффициента:</label>
            </div>
            <div class="col-sm-3">
                <Field
                    v-slot="{field, meta}"
                    name="coefficient_description"
                >
                    <input
                        v-bind="field"
                        :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                        type="text"
                        id="coefficient_description"
                    />
                </Field>
            </div>
        </div>

        <RowCheckbox name="coefficient_description_show" label="Показывать описание коэффициента" />

        <RowInput name="coefficient_variation_description" label="Описание столбца коэффициента вариантов" />

        <RowInput name="price_name" label="Наименование цены" />

        <InfoPrices />

        <RowTextarea name="admin_comment" label="Служебная информация" />

        <Instructions />

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

        <RowInputSelect
            label-input="Розничная цена"
            name-input="price_retail"
            label-input-class="fw-bold"
            type-input="number"
            label-select="Валюта"
            name-select="price_retail_currency_id"
            label-select-class="fw-bold"
            :options="currenciesStore.options"
        />

        <RowInput name="unit" label="Упаковка / Единица" />

        <RowSelect name="availability_status_id" label="Наличие" :options="availabilityStatusesStore.optionsFormatted" />
    </div>
</template>
