<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {Link, Head} from "@inertiajs/inertia-vue3"
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import {getPerPageOptions} from "@/admin/inertia/modules/common"
import {useFaqStore} from "@/admin/inertia/modules/faq"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {storeToRefs} from "pinia"
import {FaqListItem} from "@/admin/inertia/modules/faq/types"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import {Values} from "@/admin/inertia/modules/forms/indexBrands/types"
import useRoute from "@/admin/inertia/composables/useRoute"
import {useToastsStore} from "@/admin/inertia/modules/toasts"

const routesStore = useRoutesStore()
const faqStore = useFaqStore()
const toastsStore = useToastsStore()

const {faqList} = storeToRefs(faqStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<FaqListItem>(faqList)

const {revisit} = useRoute()
const {searchInput, onPerPage, handleSearch, handleClearSearch} = useSearchInput()
const perPageOptions = getPerPageOptions()

const deleteFaqs = async () => {
    if (confirm('Вы уверены, что хотите удалить выбранные производители?')) {
        await bulkDelete(checkedItems.value)
    }
}

const deleteFaq = async (faq: FaqListItem) => {
    if (confirm(`Вы уверены, что хотите удалить производителя '${faq.id}' '${faq.name}' ?`)) {
        await bulkDelete([faq.uuid])
    }
}

const bulkDelete = async (ids: Array<string>) => {
    let errorsOrVoid = await faqStore.deleteBulkBrands(ids)
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

const {indexForId} = useFormHelpers<Values>('faqs', values)
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Вопросы - Ответы" />

            <div class="breadcrumbs">
                <a :href="routesStore.route(routeNames.ROUTE_ADMIN_TEMP_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Справочники: Вопросы - Ответы <span class="adm-fav-link"></span></h1>

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
                    <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_FAQ_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
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
                        <th scope="col">Название</th>
                        <th scope="col">Символьный код</th>
                        <th scope="col">Родительский вопрос</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="faq in faqList" :key="`faq-${faq.uuid}`" @click="manualCheck(faq.uuid)">
                        <td>
                            <div class="form-check">
                                <input
                                    :disabled="editMode"
                                    v-model="checkedItems"
                                    :value="faq.uuid"
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
                                    :id="`actions-dropdown-${faq.uuid}`"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    :disabled="editMode"
                                ></button>
                                <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${faq.uuid}`">
                                    <div class="bx-core-popup-menu__arrow"></div>
                                    <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="routesStore.route(routeNames.ROUTE_ADMIN_FAQ_EDIT, {admin_faq: faq.id})">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                        <span class="bx-core-popup-menu-item-text">Изменить</span>
                                    </Link>
                                    <span class="bx-core-popup-menu-separator"></span>
                                    <button @click="deleteFaq(faq)" type="button" class="bx-core-popup-menu-item">
                                        <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                        <span class="bx-core-popup-menu-item-text">Удалить</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td><span class="main-grid-cell-content">{{faq.id}}</span></td>
                        <td>
                            <FormControlInput
                                v-if="editMode && isChecked(faq.uuid)"
                                :name="`faqs[${indexForId(faq.id)}].name`"
                                type="number"
                                :keep-value="true"
                            />
                            <span v-else class="main-grid-cell-content">{{faq.name}}</span>
                        </td>
                        <td>
                            <FormControlInput
                                v-if="editMode && isChecked(faq.uuid)"
                                :name="`faqs[${indexForId(faq.id)}].name`"
                                type="text"
                                :keep-value="true"
                            />
                            <span v-else class="main-grid-cell-content">
                                    <Link
                                        :href="routesStore.route(routeNames.ROUTE_ADMIN_FAQ_EDIT, {admin_faq: faq.id})"
                                        class="table__column-name"
                                        @click.stop=""
                                    >
                                        {{faq.name}}
                                    </Link>
                                </span>
                        </td>
                        <td>
                            <FormControlTextarea
                                v-if="editMode && isChecked(faq.uuid)"
                                :name="`faqs[${indexForId(faq.id)}].preview`"
                                :keep-value="true"
                            />
                            <span v-else class="main-grid-cell-content">{{faq.preview}}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </TheLayout>
</template>
