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

        <div class="admin-edit-variations table-responsive">
            <table class="table table-bordered table-hover" style="width: 1338px;">
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
                                <a class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" href="{{route("admin.products.edit", $product['id'])}}">
                                <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                <span class="bx-core-popup-menu-item-text">Изменить</span>
                                </a>
                                <button type="button" class="bx-core-popup-menu-item" wire:click="toggleActive({{$product['id']}})">
                                    <span class="bx-core-popup-menu-item-icon"></span>
                                    <span class="bx-core-popup-menu-item-text">
                                            @if($product['is_active'])
                                                Деактивировать
                                            @else
                                                Активировать
                                            @endif
                                        </span>
                                </button>
                                <span class="bx-core-popup-menu-separator"></span>
                                <a class="bx-core-popup-menu-item" href="{{route(\App\Constants::ROUTE_ADMIN_PRODUCTS_CREATE, ['copy_id' => $product['id']])}}">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-copy"></span>
                                    <span class="bx-core-popup-menu-item-text">Копировать</span>
                                </a>
                                <span class="bx-core-popup-menu-separator"></span>
                                <button type="button" class="bx-core-popup-menu-item" onclick="if (confirm('Вы уверены, что хотите удалить продукт `{{$product['id']}}` `{{$product['name']}}` ?')) {@this.handleDelete({{$product['id']}});}">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                    <span class="bx-core-popup-menu-item-text">Удалить</span>
                                </button>

                                <b-dropdown-item>First Action</b-dropdown-item>
                                <b-dropdown-item>Second Action</b-dropdown-item>
                                <b-dropdown-item>Third Action</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item active>Active action</b-dropdown-item>
                                <b-dropdown-item disabled>Disabled action</b-dropdown-item>
                            </b-dropdown>
                        </td>

                        @foreach($sortableColumns as $sortableColumn)
                        @switch(true)
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::ordering()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}" @if($editMode && $product['is_checked']) style="width: 200px;" @endif>
                        @if($editMode && $product['is_checked'])
                        @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.ordering", 'modifier' => '.defer'])
                        @else
                        <span class="main-grid-cell-content">{{$product['ordering']}}</span>
                        @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::name()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.name", 'modifier' => '.defer'])
                            @else
                            <span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product['id'])}}">{{$product['name']}}</a></span>
                            @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::active()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-check', ['field' => "items.{$product['uuid']}.is_active", 'modifier' => '.defer'])
                            @else
                            <span class="main-grid-cell-content">{{$product['is_active_name']}}</span>
                            @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::unit()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.unit", 'modifier' => '.defer'])
                            @else
                            <span class="main-grid-cell-content">{{$product['unit']}}</span>
                            @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::price_purchase()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            @if($editMode && $product['is_checked'])
                            <div class="form-row">
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.price_purchase", 'modifier' => '.defer'])
                                </div>
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.price_purchase_currency_id", 'options' => $currencies])
                                </div>
                            </div>
                            @else
                            <span class="main-grid-cell-content">{{$product['price_purchase_formatted']}}</span>
                            @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::price_retail()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            @if($editMode && $product['is_checked'])
                            <div class="form-row">
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-input', ['field' => "items.{$product['uuid']}.price_retail", 'modifier' => '.defer'])
                                </div>
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.price_retail_currency_id", 'options' => $currencies])
                                </div>
                            </div>
                            @else
                            <span class="main-grid-cell-content">{{$product['price_retail_formatted']}}</span>
                            @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::admin_comment()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-textarea', ['field' => "items.{$product['uuid']}.admin_comment", 'modifier' => '.defer'])
                            @else
                            <span class="main-grid-cell-content">{{$product['admin_comment']}}</span>
                            @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::availability()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-select', ['field' => "items.{$product['uuid']}.availability_status_id", 'options' => $availabilityStatuses])
                            @else
                            <span class="main-grid-cell-content">{{$product['availability_status_name']}}</span>
                            @endif
                        </td>
                        @break
                        @case($sortableColumn->equals(\Domain\Common\Enums\Column::id()))
                        <td wire:key="sortable-column-table-row-{{$sortableColumn->value}}-{{$sortableColumn->label}}">
                            <span class="main-grid-cell-content">{{$product['id']}}</span>
                        </td>
                        @break
                        @endswitch
                        @endforeach
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
        editMode: false,
        selectAll: false,
        checkedProducts: [],
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
