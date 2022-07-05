<script lang="ts" setup>
import {routeNames} from "@/admin/inertia/modules/routes"
import {ref, watch} from "vue"
import {useColumnsStore, ColumnName, isSortableColumn} from "@/admin/inertia/modules/columns"
import {useProductsStore, getActiveName, getPerPageOptions} from "@/admin/inertia/modules/products"
import TheLayout from '@/admin/inertia/shared/layout/TheLayout.vue'


const selectAll = ref(false)
const editMode = ref(false)
watch(selectAll, (newValue, oldValue) => {
    console.log('watch select all', newValue, oldValue)
})

const columnsStore = useColumnsStore()
const productStore = useProductsStore()
const checkedProducts = ref([])
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
                <button type="button" class="btn btn-primary mb-2 mr-2">Настроить</button>
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


        </div>
    </TheLayout>
</template>
