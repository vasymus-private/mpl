<template>
    <div>
        <div class="breadcrumbs">
            <a :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                <span class="breadcrumbs__text">Рабочий стол</span>
            </a>
        </div>

        <h1 class="adm-title">Каталог товаров <span class="adm-fav-link"></span></h1>

        <form-search-row :new-route="route(routeNames.ROUTE_ADMIN_PRODUCTS_CREATE)" :options="brandOptions"></form-search-row>

        <div>
            <button type="button" v-b-modal.customize-list class="btn btn-primary mb-2 mr-2">Настроить</button>
        </div>

        <div class="admin-edit-variations table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="form-check form-check-inline">
                            <input
                                :disabled="editMode"
                                :model="selectAll"
                                class="form-check-input position-static"
                                type="checkbox">
                        </div>
                    </th>
                    <th scope="col">&nbsp;</th>
                    <th v-for="sortableColumn in sortableColumns" scope="col">{{sortableColumn.label}}</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.uuid">
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
                            <b-dropdown
                                :id="`actions-dropdown-${product.uuid}`"
                                text=""
                                toggle-class="btn btn__grid-row-action-button"
                                menu-class="bx-core-popup-menu"
                            >
                                <b-dropdown-item :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_EDIT, product.id)" class="bx-core-popup-menu-item bx-core-popup-menu-item-default">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                    <span class="bx-core-popup-menu-item-text">Изменить</span>
                                </b-dropdown-item>
                                <b-dropdown-item-button @click="handleActivation(id)" class="x-core-popup-menu-item">
                                    <span class="bx-core-popup-menu-item-icon"></span>
                                    <span class="bx-core-popup-menu-item-text">{{product.is_active ? 'Деактивировать' : 'Активировать'}}</span>
                                </b-dropdown-item-button>
                                <b-dropdown-divider class="bx-core-popup-menu-separator"></b-dropdown-divider>
                                <b-dropdown-item :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_CREATE, {copy_id : product.id})" class="bx-core-popup-menu-item">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                    <span class="bx-core-popup-menu-item-text">Копировать</span>
                                </b-dropdown-item>
                                <b-dropdown-divider class="bx-core-popup-menu-separator"></b-dropdown-divider>
                                <b-dropdown-item-button @click="handleDelete(product.id)" class="x-core-popup-menu-item">
                                    <span class="bx-core-popup-menu-item-icon"></span>
                                    <span class="bx-core-popup-menu-item-text">Удалить</span>
                                </b-dropdown-item-button>
                            </b-dropdown>
                        </td>

                        <template v-for="sortableColumn in sortableColumns">
                            <td v-if="sortableColumn.value === columnNames.ordering.value" :key="sortableColumn.value">
<!--                                <b-form-input v-if="editMode && product.is_checked" v-model="product.ordering"></b-form-input>-->
                                <span class="main-grid-cell-content">{{product.ordering}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.name.value" :key="sortableColumn.value">
<!--                                <b-form-input v-if="editMode && product.is_checked" v-model="product.name"></b-form-input>-->
                                <span class="main-grid-cell-content">{{product.name}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.active.value" :key="sortableColumn.value">
                                <span class="main-grid-cell-content">{{product.is_active_name}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.unit.value" :key="sortableColumn.value">
                                <span class="main-grid-cell-content">{{product.unit}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.price_purchase.value" :key="sortableColumn.value">
                                <span class="main-grid-cell-content">{{product.price_purchase_formatted}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.price_retail.value" :key="sortableColumn.value">
                                <span class="main-grid-cell-content">{{product.price_retail_formatted}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.admin_comment.value" :key="sortableColumn.value">
                                <span class="main-grid-cell-content">{{product.admin_comment}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.availability.value" :key="sortableColumn.value">
                                <span class="main-grid-cell-content">{{product.availability_status_name}}</span>
                            </td>
                            <td v-if="sortableColumn.value === columnNames.id.value" :key="sortableColumn.value">
                                <span class="main-grid-cell-content">{{product.id}}</span>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modals -->
        <b-modal
            class="modal fade"
            id="customize-list"
            title="Настройка списка"
            v-model="modalShow"
        >
            <div class="card">
                <draggable
                    :list="tempSortableColumns"
                    :disabled="!sortColumnsEnabled"
                    class="list-group list-group-flush"
                >
                    <div
                        class="list-group-item"
                        v-for="sortableColumn in tempSortableColumns"
                        :key="sortableColumn.value"
                    >
                        {{ sortableColumn.label }}
                    </div>
                </draggable>
            </div>
            <template #modal-footer>
                <button @click="saveSortedColumns" type="button" class="btn btn-primary">Сохранить</button>
                <button @click="modalShow = false" type="button" class="btn btn-secondary">Отменить</button>
                <button @click="defaultSortedColumns" type="button" class="btn btn-secondary">Сбросить</button>
            </template>
        </b-modal>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue';
import TheLayout from "@/admin/shared/layout/TheLayout";
import routeNames from "@/admin/mixins/routeNames";
import draggable from 'vuedraggable';
import Vue from "vue";
import axios from 'axios';
import columnNames from "@/admin/mixins/columnNames";
import FormSearchRow from "@/admin/components/FormSearchRow";

export default {
    layout: TheLayout,
    components: {
        Head,
        draggable,
        FormSearchRow,
    },
    mixins: [
        routeNames,
        columnNames,
    ],
    props: {
        productsPaginated: Object,
        auth: Object,
        adminProductColumns: Array,
        editMode: false,
        selectAll: false,
        columnEnums: Object,
        brandOptions: Array,
    },
    data() {
        return {
            sortableColumns: Vue.util.extend([], this.adminProductColumns),
            tempSortableColumns: Vue.util.extend([], this.adminProductColumns),
            checkedProducts: [],
            sortColumnsEnabled: true,
            modalShow: false,
            products: Vue.util.extend([], this.productsPaginated.data)
        }
    },
    computed: {
        columns() {
            return this.columnEnums
        }
    },
    methods: {
        saveSortedColumns() {
            this.sortColumnsEnabled = false
            axios
                .put(this.route(this.routeNames.ROUTE_ADMIN_AJAX_SORT_COLUMNS), {
                    adminProductColumns: this.sortableColumns.map(item => item.value)
                })
                .then((axiosResponse = {}) => {
                    let {data: {data : {adminProductColumns = []}}} = axiosResponse
                    this.sortableColumns = adminProductColumns
                    this.tempSortableColumns = Vue.util.extend([], adminProductColumns)
                })
                .finally(() => {
                    this.sortColumnsEnabled = true
                    this.modalShow = false
                })
        },
        defaultSortedColumns() {
            this.sortColumnsEnabled = false
            axios
                .put(this.route(this.routeNames.ROUTE_ADMIN_AJAX_SORT_COLUMNS), {
                    adminProductColumnsDefault: true
                })
                .then((axiosResponse = {}) => {
                    let {data: {data : {adminProductColumns = []}}} = axiosResponse
                    this.sortableColumns = adminProductColumns
                    this.tempSortableColumns = Vue.util.extend([], adminProductColumns)
                })
                .finally(() => {
                    this.sortColumnsEnabled = true
                    this.modalShow = false
                })
        },
        handleActivation(id) {

        },
        handleDelete(id) {

        }
    },
    created() {
        console.log('--- productsPaginated', this.productsPaginated)
        console.log('--- auth', this.auth)
    }
}
</script>
