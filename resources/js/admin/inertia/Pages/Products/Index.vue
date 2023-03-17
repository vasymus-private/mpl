<script lang="ts" setup>
import {computed, defineAsyncComponent, onUnmounted, watchEffect} from 'vue'
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {isSortableColumn, useColumnsStore} from "@/admin/inertia/modules/columns"
import {useProductsStore} from "@/admin/inertia/modules/products"
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import {getActiveName, getPerPageOptions} from '@/admin/inertia/modules/common'
import {useModalsStore} from "@/admin/inertia/modules/modals"
import {ModalType} from "@/admin/inertia/modules/modals/types"
import {ProductListItem} from "@/admin/inertia/modules/products/types"
import {Head, Link} from "@inertiajs/inertia-vue3"
import {ColumnName, ColumnType, ResizeColumnType} from "@/admin/inertia/modules/columns/types"
import {useBrandsStore} from "@/admin/inertia/modules/brands"
import {useForm} from 'vee-validate'
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"
import FormControlSelect from '@/admin/inertia/components/forms/vee-validate/FormControlSelect.vue'
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import FormCheckInput from '@/admin/inertia/components/forms/vee-validate/FormCheckInput.vue'
import FormControlTextarea from '@/admin/inertia/components/forms/vee-validate/FormControlTextarea.vue'
import {useAvailabilityStatusesStore} from "@/admin/inertia/modules/availabilityStatuses"
import {getValidationSchema, useIndexProductsFormStore} from "@/admin/inertia/modules/forms/indexProducts"
import {Values} from "@/admin/inertia/modules/forms/indexProducts/types"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {storeToRefs} from "pinia"
import useRoute from "@/admin/inertia/composables/useRoute"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {Option, UrlParams} from "@/admin/inertia/modules/common/types"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import ProductCategories from '@/admin/inertia/components/products/forms/ProductCategories.vue'
import {useMounted} from '@vueuse/core'
import useResizeColumnObserving from "@/admin/inertia/composables/useResizeColumnObserving";


const isMounted = useMounted()
const Multiselect = defineAsyncComponent(() => import('@/admin/inertia/vendor/vue-multiselect/Multiselect.vue'))

const columnsStore = useColumnsStore()
const productStore = useProductsStore()
const brandsStore = useBrandsStore()
const modalsStore = useModalsStore()
const routesStore = useRoutesStore()
const currenciesStore = useCurrenciesStore()
const availabilitiesStore = useAvailabilityStatusesStore()
const indexProductsForm = useIndexProductsFormStore()
const toastsStore = useToastsStore()
const categoriesStore = useCategoriesStore()

const {productListItems} = storeToRefs(productStore)

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
const {getUrlParam, visit, visitWithoutUrlParam, revisit} = useRoute()
const {searchInput, onPerPage, handleSearch, handleClearSearch} = useSearchInput()

const brand = computed({
    get() {
        let brandId = getUrlParam(UrlParams.brand_id)
        if (!brandId) {
            return null
        }

        return brandsStore.option(`${brandId}`)
    },
    set(brandOption: Option) {
        visit({
            [UrlParams.brand_id]: brandOption ? brandOption.value : null,
        })
    }
})

const perPageOptions = getPerPageOptions()

const toggleActive = async (product: ProductListItem) => {
    await indexProductsForm.submitIndexProducts([product.uuid], {
        products: [
            {
                ...product,
                is_active: !product.is_active,
            }
        ]
    })
}

const {errors, submitCount, handleSubmit, values, setValues, validate, isSubmitting} = useForm<Values>({
    validationSchema: getValidationSchema(),
    keepValuesOnUnmount: true,
    initialValues: {
        products: []
    }
})

const deleteProducts = async () => {
    if (confirm('Вы уверены, что хотите удалить выбранные продукты?')) {
        await bulkDelete(checkedItems.value)
    }
}

const deleteProduct = async (product: ProductListItem) => {
    if (confirm(`Вы уверены, что хотите удалить продукт '${product.id}' '${product.name}' ?`)) {
        await bulkDelete([product.uuid])
    }
}

const bulkDelete = async (ids: Array<string>) => {
    let errorsOrVoid = await productStore.deleteBulkProducts(ids)
    if (!errorsOrVoid) {
        revisit()
        return
    }

    for (let key in errorsOrVoid) {
        toastsStore.error({
            title: key,
            message: errorsOrVoid[key]
        })
    }
}

const {indexForId} = useFormHelpers<Values>('products', values)

watchEffect(() => {
    setValues({
        products: productListItems.value.map((product: ProductListItem) => {
            let {id, uuid, ordering, name, is_active, unit, price_purchase, price_purchase_currency_id, price_retail, price_retail_currency_id, availability_status_id, admin_comment, category_id, relatedCategoriesIds} = product

            return {
                id,
                uuid,
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
                category_id,
                relatedCategoriesIds,
            }
        })
    })
})

watchSelectAll()

const onSubmit = handleSubmit(async (values, ctx) => {
    const errorFields = await indexProductsForm.submitIndexProducts(checkedItems.value, values)
    if (errorFields) {
        ctx.setErrors(errorFields)
        return
    }
    editMode.value = false
})

const {handleObserveResizingRef, stopObserving} = useResizeColumnObserving(ResizeColumnType.adminProductColumns)

onUnmounted(() => stopObserving())
</script>

<template>
    <TheLayout>
        <div :style="{paddingRight: '10px'}">
            <Head title="Товары" />
            <div class="breadcrumbs">
                <a :href="routesStore.route(routeNames.ROUTE_ADMIN_TEMP_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Каталог товаров <span class="adm-fav-link"></span></h1>

            <div class="search form-group row">
                <div class="col-xs-12 col-sm-8">
                    <div class="input-group mb-3">
                        <template v-for="option in routesStore.productsUrlParamOptions" :key="`${option.urlParam}-${option.value}`">
                            <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{option.label}}</span>
                            <button @click="visitWithoutUrlParam(option.urlParam)" class="btn input-group-prepend__remove" type="button"></button>
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
                            v-if="searchInput"
                            @click="handleClearSearch"
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
                        v-if="isMounted"
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
                    <div class="dropdown">
                        <button
                            class="btn btn-secondary dropdown-toggle w-100"
                            type="button"
                            id="dropdown-create-category-or-product"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >Создать</button>
                        <div class="dropdown-menu" aria-labelledby="dropdown-create-category-or-product">
                            <Link
                                :href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_CREATE)"
                                class="dropdown-item"
                            >Раздел</Link>
                            <Link
                                :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE)"
                                class="dropdown-item"
                            >Товар</Link>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button
                    @click="modalsStore.openModal(ModalType.SORT_ADMIN_COLUMNS, {type: ColumnType.adminProductColumns})"
                    class="btn btn-primary mb-2 me-2"
                    type="button"
                >Настроить</button>

                <button
                    @click="columnsStore.handleRestoreColumnSizes(ResizeColumnType.adminProductColumns)"
                    class="btn btn-secondary mb-2 me-2"
                    type="button"
                >Сбросить колонки</button>

                <button
                    v-if="columnsStore.isSomeColumnResized(ResizeColumnType.adminProductColumns)"
                    @click="columnsStore.handleStoreColumnSizes(ResizeColumnType.adminProductColumns)"
                    class="btn btn-info mb-2 me-2"
                    type="button"
                >Сохранить колонки</button>
            </div>

            <form id="form-products-list" @submit="onSubmit" novalidate>
                <div class="admin-edit-variations table-responsive" :style="{overflowY: 'hidden'}">
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
                            <th
                                v-for="sortableColumn in columnsStore.adminProductColumns"
                                :key="sortableColumn.value"
                                scope="col"
                            >
                                <div
                                    class="inner-resize"
                                    :ref="el => handleObserveResizingRef(el, sortableColumn)"
                                    :style="{width: columnsStore.adminProductsColumnWidth(sortableColumn)}"
                                >{{sortableColumn.label}}</div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in productListItems" :key="product.uuid" @click="manualCheck(product.uuid)">
                            <td>
                                <div class="form-check">
                                    <input
                                        :disabled="editMode"
                                        v-model="checkedItems"
                                        :value="product.uuid"
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
                                        :disabled="editMode"
                                    ></button>
                                    <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${product.uuid}`">
                                        <div class="bx-core-popup-menu__arrow"></div>
                                        <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id})">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                            <span class="bx-core-popup-menu-item-text">Изменить</span>
                                        </Link>
                                        <button @click="toggleActive(product)" type="button" class="bx-core-popup-menu-item">
                                            <span class="bx-core-popup-menu-item-icon"></span>
                                            <span class="bx-core-popup-menu-item-text"> {{ product.is_active ? 'Деактивировать' : 'Активировать' }}</span>
                                        </button>
                                        <span class="bx-core-popup-menu-separator"></span>
                                        <Link class="bx-core-popup-menu-item" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE, {copy_id : product.id})">
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
                                        v-if="editMode && isChecked(product.uuid)"
                                        :name="`products[${indexForId(product.id)}].ordering`"
                                        type="number"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{product.ordering}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.name)" :class="`sortable-column-${sortableColumn.value}`" @click.stop="">
                                    <FormControlInput
                                        v-if="editMode && isChecked(product.uuid)"
                                        :name="`products[${indexForId(product.id)}].name`"
                                        type="text"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">
                                        <Link
                                            :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id})"
                                        >{{product.name}}</Link>
                                    </span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.active)" :class="`sortable-column-${sortableColumn.value}`">
                                    <FormCheckInput
                                        v-if="editMode && isChecked(product.uuid)"
                                        :name="`products[${indexForId(product.id)}].is_active`"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{getActiveName(product.is_active)}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.unit)" :class="`sortable-column-${sortableColumn.value}`">
                                    <FormControlInput
                                        v-if="editMode && isChecked(product.uuid)"
                                        :name="`products[${indexForId(product.id)}].unit`"
                                        type="text"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{product.unit}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.price_purchase)" :class="`sortable-column-${sortableColumn.value}`">
                                    <div v-if="editMode && isChecked(product.uuid)" class="row">
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
                                    <div v-if="editMode && isChecked(product.uuid)" class="row">
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
                                        v-if="editMode && isChecked(product.uuid)"
                                        :name="`products[${indexForId(product.id)}].admin_comment`"
                                        :rows="2"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{product.admin_comment}}</span>
                                </td>
                                <td :class="`sortable-column-${sortableColumn.value}`" v-if="isSortableColumn(sortableColumn, ColumnName.availability)">
                                    <FormControlSelect
                                        v-if="editMode && isChecked(product.uuid)"
                                        :name="`products[${indexForId(product.id)}].availability_status_id`"
                                        :options="availabilitiesStore.options"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{availabilitiesStore.formattedName(product.availability_status_id)}}</span>
                                </td>
                                <td :class="`sortable-column-${sortableColumn.value}`" v-if="isSortableColumn(sortableColumn, ColumnName.id)">
                                    <span class="main-grid-cell-content">{{product.id}}</span>
                                </td>
                                <td v-if="isSortableColumn(sortableColumn, ColumnName.categories)" :class="`sortable-column-${sortableColumn.value}`">
                                    <template v-if="editMode && isChecked(product.uuid)">
                                        <div :style="{maxHeight: '300px', minHeight: '300px', overflowY: 'auto', paddingLeft: '10px'}">
                                            <ProductCategories :name-prefix="`products[${indexForId(product.id)}].`" />
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div>Основной: {{ categoriesStore.categoriesItem(product.category_id)?.name || '--' }}</div>
                                        <div>
                                            Дополнительные:
                                            <template v-if="product.relatedCategoriesIds.length">
                                                <ul>
                                                    <li v-for="relatedCategoryId in product.relatedCategoriesIds" :key="`related-category-${relatedCategoryId}`">
                                                        {{ categoriesStore.categoriesItem(relatedCategoryId)?.name }}
                                                    </li>
                                                </ul>
                                            </template>
                                            <template v-else>--</template>
                                        </div>
                                    </template>
                                </td>
                            </template>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <template v-if="Object.values(errors).length && submitCount > 0">
                <ul class="list-group">
                    <li v-for="error in errors" :key="error" class="list-group-item list-group-item-danger">
                        {{ error }}
                    </li>
                </ul>
            </template>

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
