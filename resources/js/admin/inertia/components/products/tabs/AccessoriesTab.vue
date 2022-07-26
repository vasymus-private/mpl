<script lang="ts" setup>
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import InputGroup from "@/admin/inertia/components/forms/InputGroup.vue"
import {ref} from 'vue'
import Option from "@/admin/inertia/modules/common/Option"
// @ts-ignore
import Multiselect from 'vue-multiselect'
import {useCategoriesTreeStore} from "@/admin/inertia/modules/categoriesTree"
import {useFormsStore} from "@/admin/inertia/modules/forms"
import {ProductProductType, SearchProduct} from "@/admin/inertia/modules/products/Product"
import {chunk} from 'lodash'
import {useFieldArray} from "vee-validate"
import {routeNames} from "@/admin/inertia/modules/routes"


const categoriesTreeStore = useCategoriesTreeStore()
const formsStore = useFormsStore()
const search = ref<string>(null)
const categories = ref<Array<Option>>(null)
const onSearchClick = () => {
    fetchItems()
}
const onSelectClose = () => {
    fetchItems()
}
const fetchItems = () => {
    formsStore.fetchSearchProducts({
        category_ids: categories.value ? categories.value.map((item: Option) => item.value) : [],
        search: search.value,
    }, ProductProductType.TYPE_ACCESSORY)
}

interface OtherProduct {id: number, uuid?: string, name?: string, image?: string, price_rub_formatted?: string}
const {fields, push, remove} = useFieldArray<OtherProduct>('accessories')
const isChecked = (id: number): boolean => {
    for (let i = 0; i < fields.value.length; i++) {
        if (fields.value[i].value.id === id) {
            return true
        }
    }
    return false
}
const onChange = (event, product: SearchProduct) => {
    if (event.target.checked) {
        push({
            id: product.id,
            uuid: product.uuid,
            name: product.name,
            image: product.image,
            price_rub_formatted: product.price_rub_formatted,
        })
        return
    }

    let idx = fields.value.findIndex(field => field.value.id === product.id)
    remove(idx)
}
</script>

<template>
    <div class="item-edit product-edit">
        <RowInput name="accessory_name" label="Переименовать 'Аксессуары'" />

        <p class="h3">Аксессуары</p>

        <div v-for="(fieldsChunk, chunkIdx) in chunk<OtherProduct>(fields, 3)" class="row">
            <div v-for="(field, idx) in fieldsChunk" :key="field.value.id" class="col-sm-4">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex justify-content-center">
                            <img class="img-fluid mw-100" :src="field.value.image" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="h6 card-title">
                                    <a target="_blank" :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: field.value.id})">{{field.value.name}}</a>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">{{field.value.price_rub_formatted}}</small>
                                </p>
                                <div class="d-flex justify-content-end">
                                    <button @click="remove(chunkIdx * 3 + idx)" type="button" class="btn-close" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <Multiselect
                    v-model="categories"
                    @close="onSelectClose"
                    :options="categoriesTreeStore.options"
                    :multiple="true"
                    :close-on-select="false"
                    placeholder="Категория"
                    :show-labels="false"
                    label="label"
                    track-by="value"
                >
                    <template #selection="{ values, search, isOpen }">
                        <span class="multiselect__single" v-if="values.length && !isOpen">опций выбрано: {{ values.length }} шт.</span>
                    </template>
                </Multiselect>
            </div>
            <div class="col-sm-6">
                <InputGroup v-model="search" placeholder="Название" @click="onSearchClick" />
            </div>
        </div>

        <table
            v-if="formsStore.searchProducts(ProductProductType.TYPE_ACCESSORY).length"
            :class="['table', formsStore.searchProductsLoading(ProductProductType.TYPE_ACCESSORY) ? 'loading' : '']"
        >
            <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Название</th>
                <th>Цена</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in formsStore.searchProducts(ProductProductType.TYPE_ACCESSORY)">
                <td>
                    <input :checked="isChecked(product.id)" @change="onChange($event, product)" :id="`${product.uuid}`" type="checkbox"/>
                </td>
                <td>
                    <label class="mb-0" :for="`${product.uuid}`">{{product.name}}</label>
                </td>
                <td>{{product.price_rub_formatted}}</td>
            </tr>
            </tbody>
        </table>

        <p><small>Будут показаны только первые 20 результатов</small></p>
    </div>
</template>
