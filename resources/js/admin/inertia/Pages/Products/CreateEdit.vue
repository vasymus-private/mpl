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
import {Inertia} from "@inertiajs/inertia"
import Product from "@/admin/inertia/modules/products/Product"
import {randomId} from "@/admin/inertia/utils"
import {CharTypeEnum} from "@/admin/inertia/modules/charTypes/CharType"


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

const {errors, handleSubmit, values, setValues} = useForm({
    validationSchema: yup.object({
        id: yup.number().integer().truncate(),
        is_active: yup.boolean(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        ordering: yup.number().truncate(),
        brand_id: yup.number().integer(),
        coefficient: yup.number().truncate(),
        coefficient_description: yup.string().max(250).nullable(),
        coefficient_description_show: yup.boolean(),
        coefficient_variation_description: yup.string().max(250).nullable(),
        price_name: yup.string().max(250).nullable(),
        infoPrices: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                name: yup.string().required().max(250),
                price: yup.number().required().truncate(),
            })
        ).nullable(),
        admin_comment: yup.string().max(250).nullable(),
        instructions: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                name: yup.string().required().max(250),
                file_name: yup.string().required().max(250),
                url: yup.string(),
                order_column: yup.number(),
                file: yup.mixed(),
            })
        ),
        price_purchase: yup.number(),
        price_purchase_currency_id: yup.number().integer(),
        price_retail: yup.number(),
        price_retail_currency_id: yup.number().integer(),
        unit: yup.string().max(250).nullable(),
        availability_status_id: yup.number().integer(),
        preview: yup.string().max(65000).nullable(),
        description: yup.string().max(65000).nullable(),
        mainImage: yup.object({
            id: yup.number().integer().truncate(),
            name: yup.string().required().max(250),
            file_name: yup.string().required().max(250),
            url: yup.string(),
            file: yup.mixed(),
        }).nullable(),
        additionalImages: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                name: yup.string().required().max(250),
                file_name: yup.string().required().max(250),
                url: yup.string(),
                order_column: yup.number(),
                file: yup.mixed(),
            })
        ),
        charCategories: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                uuid: yup.string().required(),
                name: yup.string().required().max(250),
                product_id: yup.number().integer().truncate(),
                ordering: yup.number(),
            })
        ),
        chars: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                uuid: yup.string().required(),
                name: yup.string().required().max(250),
                value: yup.string().required().max(250),
                product_id: yup.number().integer().truncate(),
                type_id: yup.number().integer().truncate(),
                category_id: yup.number().integer().truncate(),
                category_uuid: yup.string().required(),
                ordering: yup.number(),
            })
        ),
        tempCharCategoryName: yup.string().max(250).nullable(),
        tempChar: yup.object({
            name: yup.string().max(250).nullable(),
            type_id: yup.number().integer().truncate(),
            category_uuid: yup.string().nullable(),
        }).nullable(),
        seo: yup.object({
            title: yup.string().max(250).nullable(),
            h1: yup.string().max(250).nullable(),
            keywords: yup.string().max(65000).nullable(),
            description: yup.string().max(65000).nullable(),
        }).nullable(),
        category_id: yup.number().integer().truncate(),
        relatedCategoriesIds: yup.array().of(yup.number().integer()),
        accessory_name: yup.string().max(250).nullable(),
        similar_name: yup.string().max(250).nullable(),
        related_name: yup.string().max(250).nullable(),
        work_name: yup.string().max(250).nullable(),
        instruments_name: yup.string().max(250).nullable(),
        accessories: yup.array().of(
            yup.object({
                id: yup.number().integer().required(),
                uuid: yup.string().nullable(),
                name: yup.string().nullable(),
                image: yup.string().nullable(),
                price_rub_formatted: yup.string().nullable(),
            })
        ).nullable(),
        similar: yup.array().of(
            yup.object({
                id: yup.number().integer().required(),
                uuid: yup.string().nullable(),
                name: yup.string().nullable(),
                image: yup.string().nullable(),
                price_rub_formatted: yup.string().nullable(),
            })
        ).nullable(),
        related: yup.array().of(
            yup.object({
                id: yup.number().integer().required(),
                uuid: yup.string().nullable(),
                name: yup.string().nullable(),
                image: yup.string().nullable(),
                price_rub_formatted: yup.string().nullable(),
            })
        ).nullable(),
        works: yup.array().of(
            yup.object({
                id: yup.number().integer().required(),
                uuid: yup.string().nullable(),
                name: yup.string().nullable(),
                image: yup.string().nullable(),
                price_rub_formatted: yup.string().nullable(),
            })
        ).nullable(),
        instruments: yup.array().of(
            yup.object({
                id: yup.number().integer().required(),
                uuid: yup.string().nullable(),
                name: yup.string().nullable(),
                image: yup.string().nullable(),
                price_rub_formatted: yup.string().nullable(),
            })
        ).nullable(),
    })
})

watch(values, newValues => {
    formsStore.setProductForm(newValues)
})

watch(() => productsStore.product, (product: Product|null) => {
    const {
        id,
        is_active,
        name,
        slug,
        ordering,
        brand_id,
        coefficient,
        coefficient_description,
        coefficient_description_show,
        coefficient_variation_description,
        price_name,
        infoPrices = [],
        admin_comment,
        instructions = [],
        price_purchase,
        price_purchase_currency_id,
        price_retail,
        price_retail_currency_id,
        unit,
        availability_status_id,
        preview,
        description,
        mainImage,
        additionalImages = [],
        charCategories = [],
        seo,
        category_id,
        relatedCategoriesIds,
        accessory_name,
        similar_name,
        related_name,
        work_name,
        instruments_name,
        accessories,
        similar,
        related,
        works,
        instruments,
    } = product || {}
    const _charCategories = charCategories.map(({id, name, product_id, ordering, chars}) => ({id, name, product_id, ordering, uuid: randomId(), chars}))
    const chars = _charCategories.reduce((acc, {chars, uuid}) => {
        return [
            ...acc,
            ...chars.map(char => ({
                ...char,
                uuid: randomId(),
                category_uuid: uuid,
                is_rate: char.type_id === CharTypeEnum.rate,
            }))
        ]
    }, [])
    setValues({
        id,
        is_active,
        name,
        slug,
        ordering,
        brand_id,
        coefficient,
        coefficient_description,
        coefficient_description_show,
        coefficient_variation_description,
        price_name,
        infoPrices,
        admin_comment,
        instructions,
        price_purchase,
        price_purchase_currency_id,
        price_retail,
        price_retail_currency_id,
        unit,
        availability_status_id,
        preview,
        description,
        mainImage,
        additionalImages,
        charCategories: _charCategories,
        chars,
        seo,
        category_id,
        relatedCategoriesIds,
        accessory_name,
        similar_name,
        related_name,
        work_name,
        instruments_name,
        accessories,
        similar,
        related,
        works,
        instruments,
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
