<script lang="ts" setup>
import {routeNames} from "@/admin/inertia/modules/routes"
import {Ref, ref, watch} from "vue"
import {ColumnName, isSortableColumn, useColumnsStore} from "@/admin/inertia/modules/columns"
import {getActiveName, getPerPageOptions, useProductsStore} from "@/admin/inertia/modules/products"
import TheLayout from '@/admin/inertia/shared/layout/TheLayout.vue'
import Pagination from "@/admin/inertia/shared/layout/Pagination.vue"
import {Inertia} from "@inertiajs/inertia"
import Option from "@/admin/inertia/modules/common/Option"
import {ModalType, useModalsStore} from "@/admin/inertia/modules/modals"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"


const selectAll = ref(false)
const editMode = ref(false)
watch(selectAll, (newValue) => {
    if (newValue === true) {
        checkedProducts.value = productStore.productListItems.map((item: ProductListItem) => item.id)
    }

    if (newValue === false) {
        checkedProducts.value = []
    }
})

const columnsStore = useColumnsStore()
const productStore = useProductsStore()
const checkedProducts: Ref<Array<number>> = ref([])
const perPageOptions = getPerPageOptions()

const onPerPage = (perPage: Option) => {
    const to = new URL(location.href)
    to.searchParams.set('per_page', `${perPage.value}`)
    Inertia.visit(to.toString())
}

const modalsStore = useModalsStore()

const deleteProducts = () => {
    if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) { // todo temporary until modals simple confirm implementation
        productStore.handleDelete(checkedProducts.value)
    }
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

            <div>
                <button type="button" @click="modalsStore.openModal(ModalType.SORT_PRODUCTS_COLUMNS)" class="btn btn-primary mb-2 mr-2"
                >Настроить</button>
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

                        </td>

                        <template v-for="sortableColumn in columnsStore.adminProductColumns" :key="sortableColumn.value">
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.ordering)">
                                <!--<b-form-input v-if="editMode && product.is_checked" v-model="product.ordering"></b-form-input>-->
                                <span class="main-grid-cell-content">{{product.ordering}}</span>
                            </td>
                            <td v-if="isSortableColumn(sortableColumn, ColumnName.name)">
                                <!--<b-form-input v-if="editMode && product.is_checked" v-model="product.name"></b-form-input>-->
                                <span class="main-grid-cell-content">{{product.name}}</span>
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
