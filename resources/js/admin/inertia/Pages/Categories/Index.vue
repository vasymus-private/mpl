<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {Link} from "@inertiajs/inertia-vue3"
import useRoute from "@/admin/inertia/composables/useRoute"
import {storeToRefs} from "pinia"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {CategoryListItem} from "@/admin/inertia/modules/categories/types"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {useForm} from "vee-validate"
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import {useIndexCategoriesFormStore, getValidationSchema} from "@/admin/inertia/modules/forms/indexCategories"
import {getActiveName} from '@/admin/inertia/modules/common'
import FormCheckInput from '@/admin/inertia/components/forms/vee-validate/FormCheckInput.vue'
import {watch} from "vue"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import {Values} from "@/admin/inertia/modules/forms/indexCategories/types"
import {useToastsStore} from "@/admin/inertia/modules/toasts"


const routesStore = useRoutesStore()
const indexCategoriesFormStore = useIndexCategoriesFormStore()
const categoriesStore = useCategoriesStore()
const toastsStore = useToastsStore()

const {listItems : categoriesList} = storeToRefs(categoriesStore)
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
} = useCheckedItems<CategoryListItem>(categoriesList)
const {visit, removeUrlParam, revisit} = useRoute(fullUrl)
const {searchInput, handleSearch, handleClearSearch} = useSearchInput(fullUrl)

const {errors, submitCount, handleSubmit, values, setValues, validate, isSubmitting} = useForm<Values>({
    validationSchema: getValidationSchema(),
    keepValuesOnUnmount: true,
    initialValues: {
        categories: []
    }
})

const onSubmit = handleSubmit(async (values, ctx) => {
    const errorFields = await indexCategoriesFormStore.submitIndexCategories(checkedItems.value, values)
    if (errorFields) {
        ctx.setErrors(errorFields)
        return
    }
    editMode.value = false
})

const getLinkHref = (categoryId: number): string => {
    const hasSubcategories = categoriesStore.hasSubcategories(categoryId)
    if (hasSubcategories) {
        return routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX, {category_id: categoryId})
    }

    return routesStore.route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id: categoryId})
}

const toggleActive = async (category: CategoryListItem) => {
    await indexCategoriesFormStore.submitIndexCategories([category.id], {
        categories: [
            {
                ...category,
                is_active: !category.is_active
            }
        ]
    })
}

const deleteCategories = async () => {
    if (confirm('Вы уверены, что хотите удалить выбранные категории?')) {
        await bulkDelete(checkedItems.value)
    }
}

const deleteCategory = async (category: CategoryListItem) => {
    if (confirm(`Вы уверены, что хотите удалить категорию '${category.id}' '${category.name}' ?`)) {
        await bulkDelete([category.id])
    }
}

const bulkDelete = async (ids: Array<number>) => {
    let errorsOrVoid = await categoriesStore.deleteBulkCategories(ids)
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

const {indexForId} = useFormHelpers<Values>('categories', values)

watch(categoriesList, (categories: Array<CategoryListItem>) => {
    setValues({
        categories: categories.map(item => ({
            id: item.id,
            ordering: item.ordering,
            name: item.name,
            is_active: item.is_active,
        }))
    })
})

watchSelectAll()
</script>

<template>
    <TheLayout>
        <div>
            <div class="breadcrumbs">
                <a :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Каталог товаров: Разделы <span class="adm-fav-link"></span></h1>

            <div class="search form-group row">
                <div class="col-xs-12 col-sm-10">
                    <div class="input-group mb-3">
                        <template v-for="option in routesStore.categoriesUrlParamOptions" :key="`${option.type}-${option.value}`">
                            <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{option.label}}</span>
                            <button @click="removeUrlParam(option.type)" class="btn input-group-prepend__remove" type="button"></button>
                        </template>
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
                    <Link :href="route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
                </div>
            </div>

            <form id="form-categories-list" @submit="onSubmit" novalidate>
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
                            <th scope="col">Название</th>
                            <th scope="col">Сортировка</th>
                            <th scope="col">Активность</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categoriesList" :key="`category-${category.id}`" @click="manualCheck(category.id)">
                                <td>
                                    <div class="form-check">
                                        <input
                                            :disabled="editMode"
                                            v-model="checkedItems"
                                            :value="category.id"
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
                                            :id="`actions-dropdown-${category.id}`"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        ></button>
                                        <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${category.id}`">
                                            <div class="bx-core-popup-menu__arrow"></div>
                                            <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id: category.id})">
                                                <span class="bx-core-popup-menu-item-icon"></span>
                                                <span class="bx-core-popup-menu-item-text">Товары</span>
                                            </Link>
                                            <div class="bx-core-popup-menu__arrow"></div>
                                            <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_EDIT, {admin_category: category.id})">
                                                <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                                <span class="bx-core-popup-menu-item-text">Изменить</span>
                                            </Link>
                                            <button @click="toggleActive(category)" type="button" class="bx-core-popup-menu-item">
                                                <span class="bx-core-popup-menu-item-icon"></span>
                                                <span class="bx-core-popup-menu-item-text"> {{ category.is_active ? 'Деактивировать' : 'Активировать' }}</span>
                                            </button>
                                            <span class="bx-core-popup-menu-separator"></span>
                                            <button @click="deleteCategory(category)" type="button" class="bx-core-popup-menu-item">
                                                <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                                <span class="bx-core-popup-menu-item-text">Удалить</span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="main-grid-cell-content">{{category.id}}</span></td>
                                <td>
                                    <FormControlInput
                                        v-if="editMode && isChecked(category.id)"
                                        :name="`categories[${indexForId(category.id)}].name`"
                                        type="text"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">
                                        <Link
                                            :href="getLinkHref(category.id)"
                                            class="table__column-name"
                                            @click.stop=""
                                        >
                                            <span class="adm-submenu-item-link-icon adm-list-table-icon iblock-section-icon"></span>
                                            {{category.name}}
                                        </Link>
                                    </span>
                                </td>
                                <td>
                                    <FormControlInput
                                        v-if="editMode && isChecked(category.id)"
                                        :name="`categories[${indexForId(category.id)}].ordering`"
                                        type="number"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{category.ordering}}</span>
                                </td>
                                <td>
                                    <FormCheckInput
                                        v-if="editMode && isChecked(category.id)"
                                        :name="`categories[${indexForId(category.id)}].is_active`"
                                        :keep-value="true"
                                    />
                                    <span v-else class="main-grid-cell-content">{{getActiveName(category.is_active)}}</span>
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

            <footer key="edit-mode-on" v-if="editMode" class="footer edit-item-footer">
                <button form="form-categories-list" type="submit" :disabled="isSubmitting" class="btn btn-info">Сохранить</button>
                <button @click="cancel" type="button" class="btn btn-warning">Отменить</button>
            </footer>
            <footer key="edit-mode-off" v-else class="footer edit-item-footer">
                <button @click="editMode = true" :disabled="!checkedItems.length" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
                <button @click="deleteCategories" :disabled="!checkedItems.length" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
