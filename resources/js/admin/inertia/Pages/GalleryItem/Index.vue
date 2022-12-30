<script lang="ts" setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import FormCheckInput from '@/admin/inertia/components/forms/vee-validate/FormCheckInput.vue'
import {storeToRefs} from "pinia"
import {getActiveName, getPerPageOptions} from "@/admin/inertia/modules/common"
import useRoute from "@/admin/inertia/composables/useRoute"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {useForm} from "vee-validate"
import {Values} from "@/admin/inertia/modules/forms/indexGalleryItems/types"
import {getValidationSchema, useIndexGalleryItemsFormStore} from "@/admin/inertia/modules/forms/indexGalleryItems"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import {watch} from "vue"
import {useGalleryItemsStore} from "@/admin/inertia/modules/galleryItems"
import {GalleryItemListItem} from "@/admin/inertia/modules/galleryItems/types"


const routesStore = useRoutesStore()
const galleryItemsStore = useGalleryItemsStore()
const toastsStore = useToastsStore()
const indexGalleryItemsFormStore = useIndexGalleryItemsFormStore()

const {galleryItemList} = storeToRefs(galleryItemsStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<GalleryItemListItem>(galleryItemList)

const {revisit} = useRoute()
const {searchInput, onPerPage, handleSearch, handleClearSearch} = useSearchInput()

const {errors, submitCount, handleSubmit, values, setValues, validate, isSubmitting} = useForm<Values>({
    validationSchema: getValidationSchema(),
    keepValuesOnUnmount: true,
    initialValues: {
        galleryItems: []
    }
})

const onSubmit = handleSubmit(async (values, ctx) => {
    const errorFields = await indexGalleryItemsFormStore.submitIndexGalleryItems(checkedItems.value, values)
    if (errorFields) {
        ctx.setErrors(errorFields)
        return
    }
    editMode.value = false
})

const deleteGalleryItems = async () => {
    if (confirm('Вы уверены, что хотите удалить выбранные объекты галереи?')) {
        await bulkDelete(checkedItems.value)
    }
}

const deleteGalleryItem = async (galleryItemListItem: GalleryItemListItem) => {
    if (confirm(`Вы уверены, что хотите удалить объект галереи '${galleryItemListItem.id}' '${galleryItemListItem.name}' ?`)) {
        await bulkDelete([galleryItemListItem.uuid])
    }
}

const bulkDelete = async (ids: Array<string>) => {
    let errorsOrVoid = await galleryItemsStore.deleteBulkGalleryItems(ids)
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

const {indexForId} = useFormHelpers<Values>('galleryItems', values)

watch(galleryItemList, (galleryItems: Array<GalleryItemListItem>) => {
    setValues({
        galleryItems: galleryItems.map(item => ({
            id: item.id,
            uuid: item.uuid,
            name: item.name,
            is_active: item.is_active,
        }))
    })
})

const perPageOptions = getPerPageOptions()

watchSelectAll()
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Галерея" />

            <div class="breadcrumbs">
                <a :href="routesStore.route(routeNames.ROUTE_ADMIN_TEMP_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Справочники: Галерея <span class="adm-fav-link"></span></h1>

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
                    <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_GALLERY_ITEMS_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
                </div>
            </div>

            <form id="form-gallery-items-list" @submit="onSubmit" novalidate>
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
                            <th scope="col">Акт-ть</th>
                            <th scope="col">Сорт-ка</th>
                            <th scope="col">Родительский</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="galleryItem in galleryItemList" :key="`galleryItem-${galleryItem.id}`" @click="manualCheck(galleryItem.uuid)">
                            <td>
                                <div class="form-check">
                                    <input
                                        :disabled="editMode"
                                        v-model="checkedItems"
                                        :value="galleryItem.uuid"
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
                                        :id="`actions-dropdown-${galleryItem.id}`"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        :disabled="editMode"
                                    ></button>
                                    <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${galleryItem.id}`">
                                        <div class="bx-core-popup-menu__arrow"></div>
                                        <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="routesStore.route(routeNames.ROUTE_ADMIN_GALLERY_ITEMS_EDIT, {admin_gallery_item: galleryItem.id})">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                            <span class="bx-core-popup-menu-item-text">Изменить</span>
                                        </Link>
                                        <span class="bx-core-popup-menu-separator"></span>
                                        <button @click="deleteGalleryItem(galleryItem)" type="button" class="bx-core-popup-menu-item">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                            <span class="bx-core-popup-menu-item-text">Удалить</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td><span class="main-grid-cell-content">{{galleryItem.id}}</span></td>
                            <td>
                                <FormControlInput
                                    v-if="editMode && isChecked(galleryItem.uuid)"
                                    :name="`galleryItems[${indexForId(galleryItem.id)}].name`"
                                    type="text"
                                    :keep-value="true"
                                />
                                <span v-else class="main-grid-cell-content">
                                    <Link
                                        :href="routesStore.route(routeNames.ROUTE_ADMIN_GALLERY_ITEMS_EDIT, {admin_gallery_item: galleryItem.id})"
                                        class="table__column-name"
                                        @click.stop=""
                                    >
                                        {{galleryItem.name}}
                                    </Link>
                                </span>
                            </td>
                            <td>
                                <FormCheckInput
                                    v-if="editMode && isChecked(galleryItem.uuid)"
                                    :name="`galleryItems[${indexForId(galleryItem.id)}].is_active`"
                                    :keep-value="true"
                                />
                                <span v-else class="main-grid-cell-content">{{getActiveName(galleryItem.is_active)}}</span>
                            </td>
                            <td>
                                <FormControlInput
                                    v-if="editMode && isChecked(galleryItem.uuid)"
                                    :name="`galleryItems[${indexForId(galleryItem.id)}].ordering`"
                                    type="number"
                                    :keep-value="true"
                                />
                                <span v-else class="main-grid-cell-content">{{galleryItem.ordering}}</span>
                            </td>
                            <td>
                                <span class="main-grid-cell-content">{{galleryItemsStore.option(galleryItem.parent_id)?.label}}</span>
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
                v-if="galleryItemsStore.meta"
                :total="galleryItemsStore.meta.total"
                :current-page="galleryItemsStore.meta.current_page"
                :per-page="galleryItemsStore.getPerPageOption"
                :per-page-options="perPageOptions"
                :links="galleryItemsStore.meta.links"
                @update:perPage="onPerPage"
            />

            <footer key="edit-mode-on" v-if="editMode" class="footer edit-item-footer">
                <button form="form-gallery-items-list" type="submit" :disabled="isSubmitting" class="btn btn-info">Сохранить</button>
                <button @click="cancel" type="button" class="btn btn-warning">Отменить</button>
            </footer>
            <footer key="edit-mode-off" v-else class="footer edit-item-footer">
                <button @click="editMode = true" :disabled="!checkedItems.length" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
                <button @click="deleteGalleryItems" :disabled="!checkedItems.length" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
