<script lang="ts" setup>
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {useProductsStore} from "@/admin/inertia/modules/products"
import {Link} from "@inertiajs/inertia-vue3"
import {useField} from "vee-validate"
import {Inertia} from "@inertiajs/inertia"
import {useToastsStore} from "@/admin/inertia/modules/toasts"


const productsStore = useProductsStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()
const {value: is_with_variations, setValue: setWithVariations} = useField<boolean>('is_with_variations')
const deleteItem = async () => {
    if (!productsStore.product?.id) {
        return
    }

    if (confirm('Уверены, что хотите удалить товар?')) {
        let errorsOrVoid = await productsStore.deleteBulkProducts([productsStore.product.id])
        if (!errorsOrVoid) {
            Inertia.visit(
                routesStore.route(
                    routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX
                )
            )
            return
        }

        for (let key in errorsOrVoid) {
            toastsStore.error({
                title: key,
                message: errorsOrVoid[key]
            })
        }
    }
}
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="d-flex align-items-center col-sm-5">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {'category_id' : productsStore.product?.category_id})" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Товары</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>

                <a v-if="productsStore.product?.web_route" class="mx-2" :href="productsStore.product?.web_route" target="_blank">В магазин</a>
            </div>

            <div class="col-sm-7 d-flex align-items-center justify-content-end">
                <Link v-if="!productsStore.isCreatingProductRoute" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE, {'copy_id' : productsStore.product?.id})" class="btn__copy">Копировать</Link>
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
                <div v-if="!productsStore.isCreatingProductRoute" class="dropdown actions">
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
                        <Link class="dropdown-item" :href="routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_CREATE)">
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
</template>
