<script lang="ts" setup>
// @ts-ignore
import Multiselect from 'vue-multiselect'
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {computed, watchEffect} from "vue"
import {ColumnName, isSortableColumn, useColumnsStore} from "@/admin/inertia/modules/columns"
import {getPerPageOptions, useProductsStore} from "@/admin/inertia/modules/products"
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import Option from "@/admin/inertia/modules/common/Option"
import {getActiveName} from '@/admin/inertia/modules/common'
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import {Link} from "@inertiajs/inertia-vue3"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"
import {useBrandsStore} from "@/admin/inertia/modules/brands"
import {useForm} from 'vee-validate'
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import FormControlSelect from '@/admin/inertia/components/forms/vee-validate/FormControlSelect.vue'
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import FormCheckInput from '@/admin/inertia/components/forms/vee-validate/FormCheckInput.vue'
import FormControlTextarea from '@/admin/inertia/components/forms/vee-validate/FormControlTextarea.vue'
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"
import {
    getValidationSchema,
    useIndexProductsFormStore
} from "@/admin/inertia/modules/forms/indexProducts"
import {Values} from "@/admin/inertia/modules/forms/indexProducts/types"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {storeToRefs} from "pinia"
import useRoute, {UrlParams} from "@/admin/inertia/composables/useRoute"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"


const columnsStore = useColumnsStore()
const productStore = useProductsStore()
const brandsStore = useBrandsStore()
const modalsStore = useModalsStore()
const routesStore = useRoutesStore()
const currenciesStore = useCurrenciesStore()
const availabilitiesStore = useAvailabilityStatusesStore()
const indexProductsForm = useIndexProductsFormStore()

const {productListItems} = storeToRefs(productStore)
const {fullUrl} = storeToRefs(routesStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<ProductListItem>(productListItems)
const {getUrlParam, visit, removeUrlParam} = useRoute(fullUrl)
const {searchInput, onPerPage, handleSearch, handleClear} = useSearchInput(fullUrl)

const brand = computed({
    get() {
        let brandId = getUrlParam(UrlParams.brand_id)
        if (!brandId) {
            return null
        }

        return brandsStore.option(brandId)
    },
    set(brandOption: Option) {
        visit({
            [UrlParams.brand_id]: brandOption ? brandOption.value : null,
        })
    }
})

const perPageOptions = getPerPageOptions()

const deleteProducts = () => {
    if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) { // todo temporary until modals simple confirm implementation
        productStore.handleDelete(checkedItems.value)
    }
}
const deleteProduct = (product: ProductListItem) => {
    if (confirm(`Вы уверены, что хотите удалить продукт '${product.id}' '${product.name}' ?`)) {
        productStore.handleDelete([product.id])
    }
}
const toggleActive = (product: ProductListItem) => {
    console.log('---product', product)
}

const {errors, handleSubmit, values, setValues, validate, isSubmitting} = useForm<Values>({
    validationSchema: getValidationSchema(),
    keepValuesOnUnmount: true,
    initialValues: {
        products: []
    }
})

const {indexForId} = useFormHelpers<Values>('products', values)

watchEffect(() => {
    setValues({
        products: productListItems.value.map((product: ProductListItem) => {
            let {id, ordering, name, is_active, unit, price_purchase, price_purchase_currency_id, price_retail, price_retail_currency_id, availability_status_id, admin_comment} = product

            return {
                id,
                ordering,
                name,
                is_active,
                unit,
                price_purchase,
                price_purchase_currency_id,
                price_retail,
                price_retail_currency_id,
                availability_status_id,
                admin_comment,
            }
        })
    })
})

watchSelectAll()

const onSubmit = handleSubmit(async (values, ctx) => {
    const errorFields = await indexProductsForm.submitIndexProducts(checkedItems, values)
    if (errorFields) {
        ctx.setErrors(errorFields)
        return
    }
    editMode.value = false
})
</script>

<template>
    <TheLayout>
        <div>
            <div class="breadcrumbs">
                <a :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Каталог товаров <span class="adm-fav-link"></span></h1>

            <div class="search form-group row">
                <div class="col-xs-12 col-sm-8">
                    <div class="input-group mb-3">
                        <template v-for="option in routesStore.productsUrlParamOptions" :key="`${option.type}-${option.value}`">
                            <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{option.label}}</span>
                            <button @click="removeUrlParam(option.type)" class="btn input-group-prepend__remove" type="button"></button>
                        </template>
                        <input
                            v-model="searchInput"
                            type="text"
                            class="form-control"
                            placeholder="Фильтр + поиск"
                            aria-label="Фильтр + поиск"
                            aria-describedby="search-button"
                        />
                        <button
                            @click="handleClear"
                            class="btn-outline-secondary"
                            type="button"
                        ><i class="fa fa-times" aria-hidden="true"></i></button>
                        <button
                            @click="handleSearch"
                            class="btn-outline-secondary search-icon"
                            type="button"
                            id="search-button"
                        ><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <Multiselect
                        v-model="brand"
                        :options="brandsStore.nullableOptions"
                        :close-on-select="true"
                        placeholder="Производитель"
                        :show-labels="false"
                        label="label"
                        track-by="value"
                    />
                </div>
                <div class="col-xs-12 col-sm-2">
                    <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
                </div>
            </div>

            <div>
                <button type="button" @click="modalsStore.openModal(ModalType.SORT_ADMIN_COLUMNS, {type: ColumnType.adminProductColumns})" class="btn btn-primary mb-2 mr-2">Настроить</button>
            </div>

            <form id="form-products-list" @submit="onSubmit" novalidate>
                <div class="admin-edit-variations table-responsive">
                    <table class="table table-bordered table-hover table-products">
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
                            <th v-for="sortableColumn in columnsStore.adminProductColumns" :key="sortableColumn.value" scope="col">{{sortableColumn.label}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in productListItems" :key="product.uuid" @click="manualCheck(product.id)">
                            <td>
                                <div class="form-check">
                                    <input
                                        :disabled="editMode"
                                        v-model="checkedItems"
                                        :value="product.id"
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
                                        :id="`actions-dropdown-${product.uuid}`"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    ></button>
                                    <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${product.uuid}`">
                                        <div class="bx-core-popup-menu__arrow"></div>
                                        <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id})">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                            <span class="bx-core-popup-menu-item-text">Изменить</span>
                                        </Link>
                                        <button @click="toggleActive(product)" type="button" class="bx-core-popup-menu-item">
                                            <span class="bx-core-popup-menu-item-icon"></span>
                                            <span class="bx-core-popup-menu-item-text"> {{ product.is_active ? 'Деактивировать' : 'Активировать' }}</span>
                                        </button>
                                        <span class="bx-core-popup-menu-separator"></span>
                                        <Link class="bx-core-popup-menu-item" :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE, {copy_id : product.id})">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                            <span class="bx-core-popup-menu-item-text">Копировать</span>
                                        </Link>
                                        <span class="bx-core-popup-menu-separator"></span>
                                        <button @click="deleteProduct(product)" type="button" class="bx-core-popup-menu-item">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                            <span class="bx-core-popup-menu-item-text">Удалить</span>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <template v-for="sortableColumn in columnsStore.adminProductColumns" :key="sortableColumn.value">
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.ordering)" :class="`sortable-column-${sortableColumn.value}`">
                                    <FormControlInput
                                        v-if="editMode && isChecked(product.id)"
                                        :name="`products[${indexForId(product.id)}].ordering`"
                                        type="number"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{product.ordering}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.name)" :class="`sortable-column-${sortableColumn.value}`" @click.stop="">
                                    <FormControlInput
                                        v-if="editMode && isChecked(product.id)"
                                        :name="`products[${indexForId(product.id)}].name`"
                                        type="text"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">
                                        <Link
                                            :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id})"
                                        >{{product.name}}</Link>
                                    </span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.active)" :class="`sortable-column-${sortableColumn.value}`">
                                    <FormCheckInput
                                        v-if="editMode && isChecked(product.id)"
                                        :name="`products[${indexForId(product.id)}].is_active`"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{getActiveName(product.is_active)}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.unit)" :class="`sortable-column-${sortableColumn.value}`">
                                    <FormControlInput
                                        v-if="editMode && isChecked(product.id)"
                                        :name="`products[${indexForId(product.id)}].unit`"
                                        type="text"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{product.unit}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.price_purchase)" :class="`sortable-column-${sortableColumn.value}`">
                                    <div v-if="editMode && isChecked(product.id)" class="row">
                                        <div class="col-auto">
                                            <FormControlInput
                                                :name="`products[${indexForId(product.id)}].price_purchase`"
                                                type="number"
                                                :keep-value="true"
                                            />
                                        </div>
                                        <div class="col-auto">
                                            <FormControlSelect
                                                :name="`products[${indexForId(product.id)}].price_purchase_currency_id`"
                                                :options="currenciesStore.options"
                                                :keep-value="true"
                                            />
                                        </div>
                                    </div>
                                    <span v-else class="main-grid-cell-content">{{product.price_purchase_formatted}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.price_retail)" :class="`sortable-column-${sortableColumn.value}`">
                                    <div v-if="editMode && isChecked(product.id)" class="row">
                                        <div class="col-auto">
                                            <FormControlInput
                                                :name="`products[${indexForId(product.id)}].price_retail`"
                                                type="number"
                                                :keep-value="true"
                                            />
                                        </div>
                                        <div class="col-auto">
                                            <FormControlSelect
                                                :name="`products[${indexForId(product.id)}].price_retail_currency_id`"
                                                :options="currenciesStore.options"
                                                :keep-value="true"
                                            />
                                        </div>
                                    </div>
                                    <span v-else class="main-grid-cell-content">{{product.price_retail_formatted}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.admin_comment)" :class="`sortable-column-${sortableColumn.value}`">
                                    <FormControlTextarea
                                        v-if="editMode && isChecked(product.id)"
                                        :name="`products[${indexForId(product.id)}].admin_comment`"
                                        :rows="2"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{product.admin_comment}}</span>
                                </td>
                                <td :class="`sortable-column-${sortableColumn.value}`" v-if="isSortableColumn(sortableColumn, ColumnName.availability)">
                                    <FormControlSelect
                                        v-if="editMode && isChecked(product.id)"
                                        :name="`products[${indexForId(product.id)}].availability_status_id`"
                                        :options="availabilitiesStore.options"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{product.availability_status_name_short}}</span>
                                </td>
                                <td :class="`sortable-column-${sortableColumn.value}`" v-if="isSortableColumn(sortableColumn, ColumnName.id)">
                                    <span class="main-grid-cell-content">{{product.id}}</span>
                                </td>
                            </template>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <ul class="list-group" v-if="Object.values(errors).length">
                <li v-for="(error, index) in errors" :key="`error-${error}-${index}`" class="list-group-item list-group-item-danger">
                    {{ error }}
                </li>
            </ul>

            <Pagination
                v-if="productStore.meta"
                :total="productStore.meta.total"
                :current-page="productStore.meta.current_page"
                :per-page="productStore.getPerPageOption"
                :per-page-options="perPageOptions"
                :links="productStore.meta.links"
                @update:perPage="onPerPage"
            />

            <footer key="edit-mode-on" v-if="editMode" class="footer edit-item-footer">
                <button form="form-products-list" type="submit" :disabled="isSubmitting" class="btn btn-info">Сохранить</button>
                <button @click="cancel" type="button" class="btn btn-warning">Отменить</button>
            </footer>
            <footer key="edit-mode-off" v-else class="footer edit-item-footer">
                <button @click="editMode = true" :disabled="!checkedItems.length" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
                <button @click="deleteProducts" :disabled="!checkedItems.length" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
