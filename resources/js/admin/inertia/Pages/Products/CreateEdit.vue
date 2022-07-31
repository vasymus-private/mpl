<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {getRouteUrl, routeNames, RouteParams} from "@/admin/inertia/modules/routes"
import {useProductsStore, isCreatingProductRoute} from "@/admin/inertia/modules/products"
import {computed, onUnmounted, watch} from "vue"
import {Link} from "@inertiajs/inertia-vue3"
import {AdminTab} from "@/admin/inertia/modules/common/Tabs"
import {useField, useForm} from 'vee-validate'
import {
    getFormSchema,
    getWatchProductToFormCb,
    useCreateEditProductFormsStore
} from "@/admin/inertia/modules/forms/createEditProduct"
import {Inertia} from "@inertiajs/inertia"


const productsStore = useProductsStore()
const formsStore = useCreateEditProductFormsStore()

const isCreating = computed(() => isCreatingProductRoute())

const deleteItem = async () => {
    if (confirm('Уверены, что хотите удалить товар?')) {
        await productsStore.handleDelete([productsStore.product.id])
        Inertia.visit(getRouteUrl(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX))
    }
}

const onTabClick = (tab: AdminTab) => {
    let u = new URL(location.href)
    let s = new URLSearchParams(u.search)
    s.set(RouteParams.activeTab, tab.value)
    u.search = s.toString()
    history.replaceState(history.state, '', u.toString())
}

const {errors, handleSubmit, values, setValues, submitCount} = useForm({
    validationSchema: getFormSchema(),
})

watch(values, newValues => {
    formsStore.setProductForm(newValues)
})

watch(() => productsStore.product, getWatchProductToFormCb(setValues))

const {value: is_with_variations, setValue: setWithVariations} = useField<boolean>('is_with_variations')

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

                    <div class="col-sm-7 d-flex align-items-center justify-content-end">
                        <Link v-if="!isCreating" :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE, {'copy_id' : productsStore.product?.id})" class="btn__copy">Копировать</Link>
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
                                    <i v-if="!is_with_variations" class="fa fa-check" aria-hidden="true"></i>
                                    Товар без вариантов
                                </a>
                                <a class="dropdown-item" @click.prevent="setWithVariations(true)" href="#">
                                    <i v-if="is_with_variations" class="fa fa-check" aria-hidden="true"></i>
                                    Товар с вариантами
                                </a>
                            </div>
                        </div>
                        <div v-if="!isCreating" class="dropdown actions">
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
                <ul class="nav nav-tabs item-tabs" role="tablist">
                    <li v-for="tab in formsStore.adminTabs" :key="`${tab.value}-tab`" class="nav-item" role="presentation">
                        <button
                            :class="['nav-link', tab.value === formsStore.activeTab ? 'active' : '']"
                            :id="`${tab.value}-tab`"
                            data-bs-toggle="tab"
                            :data-bs-target="`#${tab.value}-content`"
                            type="button"
                            role="tab"
                            :aria-controls="`${tab.value}-content`"
                            aria-selected="true"
                            @click="onTabClick(tab)"
                        >{{ tab.label }}</button>
                    </li>
                </ul>
            </div>

            <form class="position-relative" @submit="onSubmit">
                <div class="tab-content">
                    <div
                        v-for="tab in formsStore.adminTabs"
                        :key="`${tab.value}-content`"
                        :class="['tab-pane', 'p-3', 'fade', tab.value === formsStore.activeTab ? 'show active' : '']"
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

            <template v-if="submitCount > 0">
                <div v-for="error in errors" :key="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ error }}
                </div>
            </template>
        </div>
    </TheLayout>
</template>
