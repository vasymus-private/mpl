<script lang="ts" setup>
// @ts-ignore
import Multiselect from 'vue-multiselect'
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {ModalType} from "@/admin/inertia/modules/modals/types"
import ModalCloseButton from '@/admin/inertia/components/modals/ModalCloseButton.vue'
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {CategoriesTreeItem} from "@/admin/inertia/modules/categories/types"
import {onMounted, ref, watch} from 'vue'
import {useBrandsStore} from "@/admin/inertia/modules/brands"
import {useProductsStore} from "@/admin/inertia/modules/products"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {SearchProduct, SearchProductVariation} from "@/admin/inertia/modules/products/Product"
import {TabEnum} from "@/admin/inertia/modules/common/Tabs"
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import {getPerPageOptions} from "@/admin/inertia/modules/common"
import Option from "@/admin/inertia/modules/common/Option"
import {useFieldArray} from "vee-validate"
import {OrderProductItem} from "@/admin/inertia/modules/orders/types"
import {useCurrenciesStore} from "@/admin/inertia/modules/currencies"


const props = defineProps<{
    type: ModalType
    modalProps: {}
}>()

const categoriesStore = useCategoriesStore()
const brandsStore = useBrandsStore()
const productsStore = useProductsStore()
const currenciesStore = useCurrenciesStore()
const routesStore = useRoutesStore()

const currentCategoryId = ref<number|null>(null)
const brand = ref<Option>(null)
const searchInput = ref<string|null>(null)
const page = ref<number>(1)
const _perPage = ref<Option|null>(null)

const perPageOptions = getPerPageOptions()

const {fields : productsFields, push, update} = useFieldArray<Partial<OrderProductItem>>('products')

const handleSearch = async () => {
    page.value = 1
    await handleFetch()
}
const handleClearSearch = async () => {
    searchInput.value = null
    page.value = 1
    await handleFetch()
}
const clickCategoryItem = async (category?: CategoriesTreeItem) => {
    currentCategoryId.value = category ? category.id : null
    page.value = 1
    await handleFetch()
}
const toggleOpenVariation = (product: SearchProduct) => {
    productsStore.toggleAdditionalOrderProductItemOpen(product)
}
const chooseProduct = (product: SearchProduct|SearchProductVariation) => {
    let index: number|undefined
    const productField = productsFields.value.find((item, i) => {
        if (item.value.id === product.id) {
            index = i
            return true
        }
    })

    if (productField) {
        update(index, {
            ...productField.value,
            order_product_count: productField.value.order_product_count + 1,
        })
    } else {
        push({
            id: product.id,
            parent_id: product.parent_id,
            uuid: product.uuid,
            name: product.name,
            unit: product.unit,
            price_purchase: product.price_purchase,
            price_purchase_currency_id: product.price_purchase_currency_id,
            price_retail: product.price_retail,
            price_retail_currency_id: product.price_retail_currency_id,
            order_product_count: 1,
            order_product_name: product.name,
            order_product_unit: product.unit,
            order_product_ordering: product.ordering,
            order_product_price_retail_rub: currenciesStore.priceRub(
                product.price_retail,
                product.price_retail_currency_id
            ),
            order_product_price_retail_rub_origin: currenciesStore.priceRub(
                product.price_retail,
                product.price_retail_currency_id
            ),
            order_product_price_retail_rub_was_updated: false,
        })
    }
}
const onPerPage = async (perPage: Option) => {
    _perPage.value = perPage
    page.value = 1
    await handleFetch()
}
const onPageClick = async (p: number) => {
    page.value = p
    await handleFetch()
}
const handleFetch = async () => {
    await productsStore.fetchAdditionalOrderProduct({
        page: page.value,
        per_page: _perPage.value ? +_perPage.value.value : 20,
        brand_id: brand.value ? +brand.value.value : null,
        category_ids: currentCategoryId.value ? [currentCategoryId.value] : null,
        search: searchInput.value ? searchInput.value : null,
    })
}

onMounted(async () => {
    await handleFetch()
})
watch<Option|null>(brand, async () => {
    page.value = 1
    await handleFetch()
}, {
    flush: "post"
})
</script>

<template>
    <Modal :type="props.type" title="Каталог товаров" class="modal-xl">
        <template #default>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8 order-2">
                        <div class="search form-group row">
                            <div class="col-xs-12 col-sm-8">
                                <div class="input-group mb-3">
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
                            <div class="col-xs-12 col-sm-4">
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
                        </div>

                        <div class="admin-edit-variations">
                            <table :style="{opacity: productsStore.additionalOrderProductSearchLoading ? 0.7 : 1}" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Акт.</th>
                                    <th scope="col">Изображение</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Действие</th>
                                    <th scope="col">Цена</th>
                                </tr>
                                </thead>
                                <tbody >
                                    <template v-for="product in productsStore.additionalOrderProductSearch" :key="product.uuid">
                                        <tr>
                                            <td>
                                                <span class="main-grid-cell-content">{{product.id}}</span>
                                            </td>
                                            <td>
                                                <span class="main-grid-cell-content">{{product.is_active ? 'Да' : 'Нет'}}</span>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <a target="_blank" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id})">
                                                        <img class="img-fluid" :src="product.image" alt="" />
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                            <span class="main-grid-cell-content">
                                                <a target="_blank" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id})">{{product.name}}</a>
                                            </span>
                                            </td>
                                            <td>
                                            <span class="main-grid-cell-content">
                                                <button
                                                    v-if="product.is_with_variations"
                                                    class="btn btn-link"
                                                    type="button"
                                                    @click="toggleOpenVariation(product)"
                                                >{{ product._is_open ? 'Свернуть' : 'Развернуть' }}</button>
                                                <button
                                                    v-else
                                                    class="btn btn-link"
                                                    type="button"
                                                    @click="chooseProduct(product)"
                                                >Выбрать</button>
                                            </span>
                                            </td>
                                            <td>
                                                <span class="main-grid-cell-content">{{product.price_rub_formatted}}</span>
                                            </td>
                                        </tr>
                                        <template v-if="product.is_with_variations && product._is_open">
                                            <tr v-for="variation in product.variations" :key="variation.uuid">
                                                <td>
                                                    <span class="main-grid-cell-content">{{`${product.id}-${variation.id}`}}</span>
                                                </td>
                                                <td>
                                                    <span class="main-grid-cell-content">{{variation.is_active ? 'Да' : 'Нет'}}</span>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <a target="_blank" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id, activeTab: TabEnum.variations})">
                                                            <img class="img-fluid" :src="variation.image" alt="" />
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                            <span class="main-grid-cell-content">
                                                <a target="_blank" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_EDIT, {admin_product: product.id, activeTab: TabEnum.variations})">{{variation.name}}</a>
                                            </span>
                                                </td>
                                                <td>
                                            <span class="main-grid-cell-content">
                                                <button
                                                    class="btn btn-link"
                                                    type="button"
                                                    @click="chooseProduct(variation)"
                                                >Выбрать</button>
                                            </span>
                                                </td>
                                                <td>
                                                    <span class="main-grid-cell-content">{{variation.price_rub_formatted}}</span>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>

                            <div :style="{opacity: productsStore.additionalOrderProductSearchLoading ? 0.7 : 1}">
                                <Pagination
                                    v-if="productsStore.additionalOrderProductSearchMeta"
                                    :total="productsStore.additionalOrderProductSearchMeta.total"
                                    :current-page="productsStore.additionalOrderProductSearchMeta.current_page"
                                    :per-page="productsStore.additionalOrderProductSearchPerPage"
                                    :per-page-options="perPageOptions"
                                    :links="productsStore.additionalOrderProductSearchMeta.links"
                                    :emit-on-page="true"
                                    @update:perPage="onPerPage"
                                    @update:page="onPageClick"
                                />
                            </div>
                        </div>
                    </div>
                    <aside ref="aside" id="aside" class="sidebar-left p-0 col-4 order-1">
                        <nav>
                            <ul class="nav pt-3">
                                <li class="nav-item">
                                    <a href="#add-order-product-categories" class="nav-link" data-bs-toggle="collapse" data-bs-target="#add-order-product-categories" role="button" aria-expanded="true">
                                        <span class="adm-arrow-icon"></span>
                                        <span class="d-flex align-items-center justify-content-center" @click="clickCategoryItem">
                                            <span class="adm-icon iblock_menu_icon_types"></span>
                                            <span class="nav-link-text">Каталог товаров</span>
                                        </span>
                                    </a>
                                    <ul id="add-order-product-categories" class="nav collapse show">
                                        <li v-for="category in categoriesStore.categories" :key="category.id" class="nav-item">
                                            <template v-if="category.subcategories.length">
                                                <a :href="`#add-order-product-categories-${category.id}`" class="nav-link sub-level-1 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false">
                                                    <span class="adm-arrow-icon"></span>
                                                    <span @click.prevent="clickCategoryItem(category)" class="d-flex align-items-center justify-content-center">
                                                        <span class="adm-icon iblock_menu_icon_sections"></span>
                                                        <span class="nav-link-text">{{ category.name }}</span>
                                                    </span>
                                                </a>
                                                <ul :id="`add-order-product-categories-${category.id}`" class="nav collapse">
                                                    <li v-for="subcategory1 in category.subcategories" :key="subcategory1.id" class="nav-item">
                                                        <template v-if="subcategory1.subcategories.length">
                                                            <a :href="`#add-order-product-categories-${subcategory1.id}`" class="nav-link sub-level-2 collapsed" data-bs-toggle="collapse" :data-bs-target="`#add-order-product-categories-${subcategory1.id}`" role="button" aria-expanded="false">
                                                                <span class="adm-arrow-icon"></span>
                                                                <span @click.prevent="clickCategoryItem(subcategory1)" class="d-flex align-items-center justify-content-center">
                                                                    <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                    <span class="nav-link-text">{{ subcategory1.name }}</span>
                                                                </span>
                                                            </a>
                                                            <ul :id="`add-order-product-categories-${subcategory1.id}`" class="nav collapse">
                                                                <li v-for="subcategory2 in subcategory1.subcategories" :key="subcategory2.id" class="nav-item">
                                                                    <template v-if="subcategory2.subcategories.length">
                                                                        <a :href="`#add-order-product-categories-${subcategory2.id}`" class="nav-link sub-level-3 collapsed" data-bs-toggle="collapse" :data-bs-target="`#add-order-product-categories-${subcategory2.id}`" role="button" aria-expanded="false">
                                                                            <span class="adm-arrow-icon"></span>
                                                                            <span @click.prevent="clickCategoryItem(subcategory2)" class="d-flex align-items-center justify-content-center">
                                                                                <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                                <span class="nav-link-text">{{ subcategory2.name }}</span>
                                                                            </span>
                                                                        </a>
                                                                        <ul :id="`add-order-product-categories-${subcategory2.id}`" class="nav collapse">
                                                                            <li v-for="subcategory3 in subcategory2.subcategories" :key="subcategory3.id" class="nav-item">
                                                                                <a href="#" @click.prevent="clickCategoryItem(subcategory3)" class="nav-link sub-level-4">
                                                                                    <span class="adm-arrow-icon-dot"></span>
                                                                                    <span class="d-flex align-items-center justify-content-center">
                                                                                        <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                                        <span class="nav-link-text">{{subcategory3.name}}</span>
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </template>
                                                                    <template v-else>
                                                                        <a href="#" @click.prevent="clickCategoryItem(subcategory2)" class="nav-link sub-level-3">
                                                                            <span class="adm-arrow-icon-dot"></span>
                                                                            <span class="d-flex align-items-center justify-content-center">
                                                                                <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                                <span class="nav-link-text">{{subcategory2.name}}</span>
                                                                            </span>
                                                                        </a>
                                                                    </template>
                                                                </li>
                                                            </ul>
                                                        </template>
                                                        <template v-else>
                                                            <a href="#" @click.prevent="clickCategoryItem(subcategory1)" class="nav-link sub-level-2">
                                                                <span class="adm-arrow-icon-dot"></span>
                                                                <span class="d-flex align-items-center justify-content-center">
                                                                    <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                    <span class="nav-link-text">{{subcategory1.name}}</span>
                                                                </span>
                                                            </a>
                                                        </template>
                                                    </li>
                                                </ul>
                                            </template>
                                            <template v-else>
                                                <a href="#" @click.prevent="clickCategoryItem(category)" class="nav-link sub-level-1">
                                                    <span class="adm-arrow-icon-dot"></span>
                                                    <span class="d-flex align-items-center justify-content-center">
                                                        <span class="adm-icon iblock_menu_icon_sections"></span>
                                                        <span class="nav-link-text">{{category.name}}</span>
                                                    </span>
                                                </a>
                                            </template>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </aside>
                </div>
            </div>
        </template>
        <template #footer>
            <ModalCloseButton :type="props.type" />
        </template>
    </Modal>
</template>
