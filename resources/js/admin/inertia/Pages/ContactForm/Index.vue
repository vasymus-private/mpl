<script lang="ts" setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import {storeToRefs} from "pinia"
import {getPerPageOptions} from "@/admin/inertia/modules/common"
import useRoute from "@/admin/inertia/composables/useRoute"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {useContactFormsStore} from "@/admin/inertia/modules/contactForms"
import {ContactFormItem} from "@/admin/inertia/modules/contactForms/types"


const routesStore = useRoutesStore()
const contactFormsStore = useContactFormsStore()
const toastsStore = useToastsStore()

const {contactFormList} = storeToRefs(contactFormsStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<ContactFormItem>(contactFormList)

const {revisit} = useRoute()
const {searchInput, onPerPage, handleSearch, handleClearSearch} = useSearchInput()

const deleteContactFormItems = async () => {
    if (confirm('Вы уверены, что хотите удалить выбранные контактные формы?')) {
        await bulkDelete(checkedItems.value)
    }
}

const deleteContactFormItem = async (item: ContactFormItem) => {
    if (confirm(`Вы уверены, что хотите удалить контактную форму '${item.id}' '${item.name}' ?`)) {
        await bulkDelete([item.uuid])
    }
}

const bulkDelete = async (ids: Array<string>) => {
    let errorsOrVoid = await contactFormsStore.deleteBulkContactFormItems(ids)
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

const perPageOptions = getPerPageOptions()

watchSelectAll()
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Контактные формы" />

            <div class="breadcrumbs">
                <a :href="routesStore.route(routeNames.ROUTE_ADMIN_TEMP_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Справочники: Контактная форма <span class="adm-fav-link"></span></h1>

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
            </div>

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
                        <th scope="col">Тип</th>
                        <th scope="col">Email</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Ip</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="contactFormItem in contactFormList" :key="`contactFormItem-${contactFormItem.id}`" @click="manualCheck(contactFormItem.uuid)">
                        <td>
                            <div class="form-check">
                                <input
                                    :disabled="editMode"
                                    v-model="checkedItems"
                                    :value="contactFormItem.uuid"
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
                                    :id="`actions-dropdown-${contactFormItem.id}`"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    :disabled="editMode"
                                ></button>
                                <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${contactFormItem.id}`">
                                    <div class="bx-core-popup-menu__arrow"></div>
                                    <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="routesStore.route(routeNames.ROUTE_ADMIN_CONTACT_FORMS_SHOW, {admin_contact_form: contactFormItem.id})">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Просмотреть</span>
                                    </Link>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="deleteContactFormItem(contactFormItem)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td><span class="main-grid-cell-content">{{contactFormItem.id}}</span></td>
                        <td>
                            <span class="main-grid-cell-content">
                                <Link
                                    :href="routesStore.route(routeNames.ROUTE_ADMIN_CONTACT_FORMS_SHOW, {admin_contact_form: contactFormItem.id})"
                                    class="table__column-name"
                                    @click.stop=""
                                >
                                    {{contactFormItem.name}}
                                </Link>
                            </span>
                        </td>
                        <td>
                            <span class="main-grid-cell-content">{{contactFormItem.type_name}}</span>
                        </td>
                        <td>
                            <span class="main-grid-cell-content">{{contactFormItem.email}}</span>
                        </td>
                        <td>
                            <span class="main-grid-cell-content">{{contactFormItem.name}}</span>
                        </td>
                        <td>
                            <span class="main-grid-cell-content">{{contactFormItem.phone}}</span>
                        </td>
                        <td>
                            <template v-if="contactFormItem.ipDetails">
                                <p class="main-grid-cell-content">{{contactFormItem.ipDetails.ip}}</p>
                                <p class="main-grid-cell-content" :title="contactFormItem.ipDetails.country_name">{{contactFormItem.ipDetails.country_a2}}</p>
                                <p class="main-grid-cell-content"><img :src="contactFormItem.ipDetails.country_img" alt=""></p>
                                <p class="main-grid-cell-content">{{contactFormItem.ipDetails.city}}</p>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <Pagination
                v-if="contactFormsStore.meta"
                :total="contactFormsStore.meta.total"
                :current-page="contactFormsStore.meta.current_page"
                :per-page="contactFormsStore.getPerPageOption"
                :per-page-options="perPageOptions"
                :links="contactFormsStore.meta.links"
                @update:perPage="onPerPage"
            />

            <footer key="edit-mode-off" v-if="!editMode" class="footer edit-item-footer">
                <button @click="deleteContactFormItems" :disabled="!checkedItems.length" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
