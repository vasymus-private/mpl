<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import {getValidationSchema, useIndexBrandsFormStore} from "@/admin/inertia/modules/forms/indexBrands"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {useBrandsStore} from "@/admin/inertia/modules/brands"
import {storeToRefs} from "pinia"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {BrandListItem} from "@/admin/inertia/modules/brands/types"
import useRoute from "@/admin/inertia/composables/useRoute"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import {useForm} from "vee-validate"
import {Values} from "@/admin/inertia/modules/forms/indexBrands/types"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import {watch} from "vue"
import {Link} from "@inertiajs/inertia-vue3"
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import FormControlTextarea from '@/admin/inertia/components/forms/vee-validate/FormControlTextarea.vue'
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import {getPerPageOptions} from "@/admin/inertia/modules/common"


const routesStore = useRoutesStore()
const indexBrandsFormStore = useIndexBrandsFormStore()
const brandsStore = useBrandsStore()
const toastsStore = useToastsStore()

const {brandsList} = storeToRefs(brandsStore)
const {fullUrl} = storeToRefs(routesStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<BrandListItem>(brandsList)
const {visit, revisit} = useRoute(fullUrl)
const {searchInput, onPerPage, handleSearch, handleClearSearch} = useSearchInput(fullUrl)

const {errors, submitCount, handleSubmit, values, setValues, validate, isSubmitting} = useForm<Values>({
    validationSchema: getValidationSchema(),
    keepValuesOnUnmount: true,
    initialValues: {
        brands: []
    }
})

const onSubmit = handleSubmit(async (values, ctx) => {
    const errorFields = await indexBrandsFormStore.submitIndexBrands(checkedItems.value, values)
    if (errorFields) {
        ctx.setErrors(errorFields)
        return
    }
    editMode.value = false
})

const deleteBrands = async () => {
    if (confirm('Вы уверены, что хотите удалить выбранные производители?')) {
        await bulkDelete(checkedItems.value)
    }
}

const deleteBrand = async (brand: BrandListItem) => {
    if (confirm(`Вы уверены, что хотите удалить производителя '${brand.id}' '${brand.name}' ?`)) {
        await bulkDelete([brand.id])
    }
}

const bulkDelete = async (ids: Array<number>) => {
    let errorsOrVoid = await brandsStore.deleteBulkBrands(ids)
    if (!errorsOrVoid) {
        revisit()
        return
    }

    for (let key in errorsOrVoid) {
        toastsStore.error({
            title: key,
            message: errorsOrVoid[key]
        })
    }
}

const {indexForId} = useFormHelpers<Values>('brands', values)

watch(brandsList, (brands: Array<BrandListItem>) => {
    setValues({
        brands: brands.map(item => ({
            id: item.id,
            ordering: item.ordering,
            name: item.name,
            preview: item.preview,
        }))
    })
})

const perPageOptions = getPerPageOptions()

watchSelectAll()
</script>

<template>
    <TheLayout>
        <div>
            <div class="breadcrumbs">
                <a :href="routesStore.route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Справочники: Производители <span class="adm-fav-link"></span></h1>

            <div class="search form-group row">
                <div class="col-xs-12 col-sm-10">
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
                <div class="col-xs-12 col-sm-2">
                    <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_BRANDS_TEMP_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
                </div>
            </div>

            <form id="form-brands-list" @submit="onSubmit" novalidate>
                <div class="admin-edit-variations table-responsive">
                    <table class="table table-hover table-products">
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
                            <th scope="col">ID</th>
                            <th scope="col">Сортировка</th>
                            <th scope="col">Название</th>
                            <th scope="col">Описание для анонса</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="brand in brandsList" :key="`brand-${brand.id}`" @click="manualCheck(brand.id)">
                            <td>
                                <div class="form-check">
                                    <input
                                        :disabled="editMode"
                                        v-model="checkedItems"
                                        :value="brand.id"
                                        class="form-check-input position-static js-product-item-checkbox"
                                        type="checkbox"
                                        @click.stop=""
                                    />
                                </div>
                            </td>
                            <td>
                                <div class="dropdown" @click.stop="">
                                    <button
                                        class="btn btn__grid-row-action-button dropdown-toggle"
                                        type="button"
                                        :id="`actions-dropdown-${brand.id}`"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    ></button>
                                    <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${brand.id}`">
                                        <div class="bx-core-popup-menu__arrow"></div>
                                        <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="routesStore.route(routeNames.ROUTE_ADMIN_BRANDS_TEMP_EDIT, {admin_brand: brand.id})">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                            <span class="bx-core-popup-menu-item-text">Изменить</span>
                                        </Link>
                                        <span class="bx-core-popup-menu-separator"></span>
                                        <button @click="deleteBrand(brand)" type="button" class="bx-core-popup-menu-item">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                            <span class="bx-core-popup-menu-item-text">Удалить</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td><span class="main-grid-cell-content">{{brand.id}}</span></td>
                            <td>
                                <FormControlInput
                                    v-if="editMode && isChecked(brand.id)"
                                    :name="`brands[${indexForId(brand.id)}].ordering`"
                                    type="number"
                                    :keep-value="true"
                                />
                                <span v-else class="main-grid-cell-content">{{brand.ordering}}</span>
                            </td>
                            <td>
                                <FormControlInput
                                    v-if="editMode && isChecked(brand.id)"
                                    :name="`brands[${indexForId(brand.id)}].name`"
                                    type="text"
                                    :keep-value="true"
                                />
                                <span v-else class="main-grid-cell-content">
                                    <Link
                                        :href="routesStore.route(routeNames.ROUTE_ADMIN_BRANDS_TEMP_EDIT, {admin_brand: brand.id})"
                                        class="table__column-name"
                                        @click.stop=""
                                    >
                                        {{brand.name}}
                                    </Link>
                                </span>
                            </td>
                            <td>
                                <FormControlTextarea
                                    v-if="editMode && isChecked(brand.id)"
                                    :name="`brands[${indexForId(brand.id)}].preview`"
                                    :keep-value="true"
                                />
                                <span v-else class="main-grid-cell-content">{{brand.preview}}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <template v-if="Object.values(errors).length && submitCount > 0">
                <ul class="list-group">
                    <li v-for="error in errors" :key="error" class="list-group-item list-group-item-danger">
                        {{ error }}
                    </li>
                </ul>
            </template>

            <Pagination
                v-if="brandsStore.meta"
                :total="brandsStore.meta.total"
                :current-page="brandsStore.meta.current_page"
                :per-page="brandsStore.getPerPageOption"
                :per-page-options="perPageOptions"
                :links="brandsStore.meta.links"
                @update:perPage="onPerPage"
            />

            <footer key="edit-mode-on" v-if="editMode" class="footer edit-item-footer">
                <button form="form-brands-list" type="submit" :disabled="isSubmitting" class="btn btn-info">Сохранить</button>
                <button @click="cancel" type="button" class="btn btn-warning">Отменить</button>
            </footer>
            <footer key="edit-mode-off" v-else class="footer edit-item-footer">
                <button @click="editMode = true" :disabled="!checkedItems.length" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
                <button @click="deleteBrands" :disabled="!checkedItems.length" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
