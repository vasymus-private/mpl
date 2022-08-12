<script lang="ts" setup>
// @ts-ignore
import Multiselect from 'vue-multiselect'
import {routeNames, UrlParams, useRoutesStore, visit} from "@/admin/inertia/modules/routes"
import {computed, ref, Ref, watch} from "vue"
import {ColumnName, isSortableColumn, useColumnsStore} from "@/admin/inertia/modules/columns"
import {getActiveName, getPerPageOptions, useProductsStore} from "@/admin/inertia/modules/products"
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import Option, {OptionType} from "@/admin/inertia/modules/common/Option"
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import {Link} from "@inertiajs/inertia-vue3"
import {ColumnType} from "@/admin/inertia/modules/columns/Column"
import {useBrandsStore} from "@/admin/inertia/modules/brands"


const columnsStore = useColumnsStore()
const productStore = useProductsStore()
const brandsStore = useBrandsStore()
const modalsStore = useModalsStore()
const routesStore = useRoutesStore()

const selectAll = ref(false)
const editMode = ref(false)
const brand = computed({
    get() {
        let brandId = routesStore.getUrlParam(UrlParams.brand_id)
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
const _searchInput = ref<string|null>(null)
const searchInput = computed<string|null>({
    get() {
        return _searchInput.value ? _searchInput.value : routesStore.getUrlParam(UrlParams.search)
    },
    set(v: string|null) {
        _searchInput.value = v
    }
})
const checkedProducts: Ref<Array<number>> = ref([])
const perPageOptions = getPerPageOptions()

const onPerPage = (perPage: Option) => {
    visit({
        [UrlParams.page]: 1,
        [UrlParams.per_page]: perPage.value,
    })
}
const handleSearch = () => {
    visit({
        [UrlParams.search]: searchInput.value,
    })
}
const handleClear = () => {
    visit({
        [UrlParams.search]: null,
        [UrlParams.brand_id]: null,
        [UrlParams.category_id]: null,
    })
}

watch(selectAll, (newValue) => {
    if (newValue === true) {
        checkedProducts.value = productStore.productListItems.map((item: ProductListItem) => item.id)
    }

    if (newValue === false) {
        checkedProducts.value = []
    }
})


const removePrepend = (type: OptionType) => {
    switch (type) {
        case OptionType.category: {
            visit({
                [UrlParams.category_id]: null,
            })
            break
        }
        case OptionType.brand: {
            visit({
                [UrlParams.brand_id]: null,
            })
            break
        }
    }
}
const deleteProducts = () => {
    if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) { // todo temporary until modals simple confirm implementation
        productStore.handleDelete(checkedProducts.value)
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
                        <template v-for="option in routesStore.urlParamOptions" :key="`${option.type}-${option.value}`">
                            <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{option.label}}</span>
                            <button @click="removePrepend(option.type)" class="btn input-group-prepend__remove" type="button"></button>
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

            <div class="admin-edit-variations table-responsive">
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
                        <th v-for="sortableColumn in columnsStore.adminProductColumns" :key="sortableColumn.value" scope="col">{{sortableColumn.label}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in productStore.productListItems" :key="product.uuid">
                        <td>
                            <div class="form-check">
                                <input
                                    :disabled="editMode"
                                    v-model="checkedProducts"
                                    :value="product.id"
                                    class="form-check-input position-static js-product-item-checkbox"
                                    type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
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
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.ordering)">
                                <!--<b-form-input v-if="editMode && product.is_checked" v-model="product.ordering"></b-form-input>-->
                                <span class="main-grid-cell-content">{{product.ordering}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.name)">
                                <!--<b-form-input v-if="editMode && product.is_checked" v-model="product.name"></b-form-input>-->
                                <span class="main-grid-cell-content">
                                    <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id})">{{product.name}}</Link>
                                </span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.active)">
                                <span class="main-grid-cell-content">{{getActiveName(product.is_active)}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.unit)">
                                <span class="main-grid-cell-content">{{product.unit}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.price_purchase)">
                                <span class="main-grid-cell-content">{{product.price_purchase_formatted}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.price_retail)">
                                <span class="main-grid-cell-content">{{product.price_retail_formatted}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.admin_comment)">
                                <span class="main-grid-cell-content">{{product.admin_comment}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.availability)">
                                <span class="main-grid-cell-content">{{product.availability_status_name_short}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.id)">
                                <span class="main-grid-cell-content">{{product.id}}</span>
                            </td>
                        </template>
                    </tr>
                    </tbody>
                </table>
            </div>

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
                <button type="button" class="btn btn-info">Сохранить</button>
                <button @click="editMode = false" type="button" class="btn btn-warning">Отменить</button>
            </footer>
            <footer key="edit-mode-off" v-else class="footer edit-item-footer">
                <button @click="editMode = true" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
                <button @click="deleteProducts" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
