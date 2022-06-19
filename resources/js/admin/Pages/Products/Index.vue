<template>
    <div>
        <div class="breadcrumbs">
            <a :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                <span class="breadcrumbs__text">Рабочий стол</span>
            </a>
        </div>

        <h1 class="adm-title">Каталог товаров <span class="adm-fav-link"></span></h1>

        <div>
            <button type="button" v-b-modal.customize-list class="btn btn-primary mb-2 mr-2">Настроить</button>
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
                    :list="sortableColumns"
                    :disabled="!sortColumnsEnabled"
                    class="list-group list-group-flush"
                >
                    <div
                        class="list-group-item"
                        v-for="sortableColumn in sortableColumns"
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

export default {
    layout: TheLayout,
    components: {
        Head,
        draggable
    },
    mixins: [
        routeNames,
    ],
    props: {
        productsPaginated: Object,
        auth: Object,
        adminProductColumns: Array,
    },
    data() {
        return {
            sortableColumns : Vue.util.extend([], this.adminProductColumns),
            sortColumnsEnabled: true,
            modalShow: false,
        }
    },
    computed: {
        products() {
            return this.productsPaginated.data
        },
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
                })
                .finally(() => {
                    this.sortColumnsEnabled = true
                    this.modalShow = false
                })
        }
    },
    created() {
        console.log('--- productsPaginated', this.productsPaginated)
        console.log('--- auth', this.auth)
    }
}
</script>
