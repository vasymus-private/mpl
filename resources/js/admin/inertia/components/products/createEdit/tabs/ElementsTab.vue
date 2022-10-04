<script lang="ts" setup>
import {useProductsStore} from "@/admin/inertia/modules/products"
import {useBrandsStore} from "@/admin/inertia/modules/brands"
import InfoPrices from "@/admin/inertia/components/products/createEdit/parts/InfoPrices.vue"
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowInputSelect from '@/admin/inertia/components/forms/vee-validate/RowInputSelect.vue'
import RowTextarea from '@/admin/inertia/components/forms/vee-validate/RowTextarea.vue'
import RowMedias from '@/admin/inertia/components/forms/vee-validate/RowMedias.vue'
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"
import RowInputInput from "@/admin/inertia/components/forms/vee-validate/RowInputInput.vue"
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'


const productsStore = useProductsStore()
const brandsStore = useBrandsStore()
const currenciesStore = useCurrenciesStore()
const availabilityStatusesStore = useAvailabilityStatusesStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!productsStore.isCreatingProductRoute" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ productsStore.product?.id }}
            </div>
        </div>

        <RowCheckbox name="is_active" label="Активность" />

        <NameAndSlug />

        <RowInput name="ordering" label="Сортировка" type="number" />

        <RowSelect name="brand_id" label="Производитель" :options="brandsStore.options" />

        <RowInputInput
            label1="Коэффициент на единицу расхода"
            name1="coefficient"
            type1="number"
            label2="Описание коэффициента"
            name2="coefficient_description"
        />

        <RowCheckbox name="coefficient_description_show" label="Показывать описание коэффициента" />

        <RowInput name="coefficient_variation_description" label="Описание столбца коэффициента вариантов" />

        <RowInput name="price_name" label="Наименование цены" />

        <InfoPrices />

        <RowTextarea name="admin_comment" label="Служебная информация" />

        <RowMedias name="instructions" label="Дополнительные файлы (инструкции)" />

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
