<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {getRouteUrl, routeNames} from "@/admin/inertia/modules/routes"
import {useProductsStore, isCreatingProductRoute} from "@/admin/inertia/modules/products"
import {computed, onUnmounted, watch} from "vue"
import {Link} from "@inertiajs/inertia-vue3"
import {TabEnum} from "@/admin/inertia/modules/products/Tabs"
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import {useFormsStore} from "@/admin/inertia/modules/forms"
import {ProductForm} from "@/admin/inertia/modules/forms/ProductForm"
import {Inertia} from "@inertiajs/inertia"


const productsStore = useProductsStore()
const formsStore = useFormsStore()

const isCreating = computed(() => isCreatingProductRoute())

const deleteItem = async () => {
    if (confirm('Уверены, что хотите удалить товар?')) {
        await productsStore.handleDelete([productsStore.product.id])
        Inertia.visit(getRouteUrl(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX))
    }
}

const setWithVariations = (is_with_variations: boolean) => {
    productsStore.handleUpdate({is_with_variations})
}

const {errors, handleSubmit, setFieldValue, values} = useForm({
    validationSchema: yup.object({
        is_active: yup.boolean(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        ordering: yup.number().truncate(),
        brand_id: yup.number().integer(),
        coefficient: yup.number().truncate(),
        coefficient_description: yup.string().max(250),
        coefficient_description_show: yup.boolean(),
    })
})

watch(values, newValues => {
    formsStore.setProductForm(newValues)
})

let keys : Array<keyof ProductForm> = [
    'is_active',
    'name',
    'slug',
    'ordering',
    'brand_id',
    'coefficient',
    'coefficient_description',
    'coefficient_description_show',
]

keys.forEach(key => {
    watch(() => productsStore.product?.[key], (value) => {
        console.log('--- watch product in form', key, value)
        setFieldValue(key, value)
    })
})

const onSubmit = handleSubmit((values, actions) => {
    console.log('--- values', values)
    console.log('--- actions', actions)
})

onUnmounted(() => {
    formsStore.setProductForm({})
})
</script>

<template>
    <TheLayout>
        <div>
            <div class="breadcrumbs">
                <Link :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </Link>
                <span class="breadcrumbs__item">
                    <span class="breadcrumbs__arrow"></span>
                </span>
                <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Каталог товаров</span>
                </Link>
            </div>
            <h1 class="h2 adm-title">
                {{ formsStore.productFormTitle }}
            </h1>

            <div class="detail-toolbar">
                <div class="row d-flex align-items-center">
                    <div class="d-flex align-items-center col-sm-5">
                        <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {'category_id' : productsStore.product?.category_id})" class="detail-toolbar__btn">
                            <span class="detail-toolbar__btn-l"></span>
                            <span class="detail-toolbar__btn-text">Товары</span>
                            <span class="detail-toolbar__btn-r"></span>
                        </Link>

                        <a v-if="productsStore.product?.web_route" class="mx-2" :href="productsStore.product?.web_route" target="_blank">В магазин</a>
                    </div>

                    <div v-if="!isCreating" class="col-sm-7 d-flex align-items-center justify-content-end">
                        <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE, {'copy_id' : productsStore.product?.id})" class="btn__copy">Копировать</Link>
                        <div class="dropdown">
                            <button
                                class="btn btn-secondary dropdown-toggle btn__dropdown"
                                type="button"
                                id="actions-dropdown-variations"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >Параметры товара</button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actions-dropdown-variations">
                                <a class="dropdown-item" @click.prevent="setWithVariations(false)" href="#">
                                    <i v-if="!productsStore.product?.is_with_variations" class="fa fa-check" aria-hidden="true"></i>
                                    Товар без вариантов
                                </a>
                                <a class="dropdown-item" @click.prevent="setWithVariations(true)" href="#">
                                    <i v-if="productsStore.product?.is_with_variations" class="fa fa-check" aria-hidden="true"></i>
                                    Товар с вариантами
                                </a>
                            </div>
                        </div>
                        <div class="dropdown actions">
                            <button
                                class="btn btn-secondary dropdown-toggle btn__dropdown"
                                type="button"
                                id="actions-dropdown-actions"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <span class="add">Действия</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actions-dropdown-actions">
                                <Link class="dropdown-item" :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE)">
                                    <span class="bx-core-popup-menu-item-icon edit"></span>
                                    Добавить элемент
                                </Link>
                                <a class="dropdown-item" @click.prevent="deleteItem" href="#">
                                    <span class="bx-core-popup-menu-item-icon delete"></span>
                                    Удалить элемент
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="js-nav-tabs-wrapper">
                <div class="js-nav-tabs-marker"></div>
                <ul class="nav nav-tabs js-nav-tabs item-tabs" role="tablist">
                    <li v-for="tab in productsStore.getAdminTabs" :key="`${tab.value}-tab`" class="nav-item" role="presentation">
                        <button
                            :class="['nav-link', tab.value === TabEnum.elements ? 'active' : '']"
                            :id="`${tab.value}-tab`"
                            data-bs-toggle="tab"
                            :data-bs-target="`#${tab.value}-content`"
                            type="button"
                            role="tab"
                            :aria-controls="`${tab.value}-content`"
                            aria-selected="true"
                        >{{ tab.label }}</button>
                    </li>
                </ul>
            </div>

            <form class="position-relative" @submit="onSubmit">
                <div class="tab-content">
                    <div
                        v-for="tab in productsStore.getAdminTabs"
                        :key="`${tab.value}-content`"
                        :class="['tab-pane', 'p-3', 'fade', tab.value === TabEnum.elements ? 'show active' : '']"
                        :id="`${tab.value}-content`"
                        role="tabpanel"
                        :aria-labelledby="`${tab.value}-tab`"
                    >
                        <component :is="tab.is" />
                    </div>
                </div>

                <div class="js-edit-footer-wrapper">
                    <div class="edit-item-footer js-edit-item-footer">
                        <button type="submit" class="btn btn-primary mb-2 btn__save mr-2">Сохранить</button>

                        <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id : productsStore.product?.category_id})" type="button" class="btn btn-info mb-2 btn__default">Отменить</Link>

                        <button type="button" class="btn btn-info js-pin-btn pin-btn"></button>
                    </div>
                </div>
            </form>

            <div v-for="error in errors" :key="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ error }}
            </div>
        </div>
    </TheLayout>
</template>
