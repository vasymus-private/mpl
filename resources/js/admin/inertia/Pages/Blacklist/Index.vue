<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {Link, Head} from "@inertiajs/inertia-vue3"
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"
import {getPerPageOptions} from "@/admin/inertia/modules/common"
import useCheckedItems from "@/admin/inertia/composables/useCheckedItems"
import {storeToRefs} from "pinia"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import {Values} from "@/admin/inertia/modules/forms/indexBlacklist/types"
import useRoute from "@/admin/inertia/composables/useRoute"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import Pagination from "@/admin/inertia/components/layout/Pagination.vue"
import {useForm} from "vee-validate"
import FormControlInput from '@/admin/inertia/components/forms/vee-validate/FormControlInput.vue'
import FormCheckInput from '@/admin/inertia/components/forms/vee-validate/FormCheckInput.vue'
import {watch} from "vue"
import {useIndexBlacklistFormStore, getValidationSchema} from "@/admin/inertia/modules/forms/indexBlacklist"
import {useBlacklistStore} from "@/admin/inertia/modules/blacklist"
import {BlacklistItem} from "@/admin/inertia/modules/blacklist/types"
import IpDetails from '@/admin/inertia/components/parts/IpDetails.vue'

const routesStore = useRoutesStore()
const indexBlacklistFormStore = useIndexBlacklistFormStore()
const blacklistStore = useBlacklistStore()
const toastsStore = useToastsStore()

const {blacklistItems} = storeToRefs(blacklistStore)

const {
    selectAll,
    editMode,
    checkedItems,
    check,
    isChecked,
    watchSelectAll,
    manualCheck,
    cancel,
} = useCheckedItems<BlacklistItem>(blacklistItems)

const {revisit} = useRoute()
const {searchInput, onPerPage, handleSearch, handleClearSearch} = useSearchInput()

const {errors, submitCount, handleSubmit, values, setValues, validate, isSubmitting} = useForm<Values>({
    validationSchema: getValidationSchema(),
    keepValuesOnUnmount: true,
    initialValues: {
        blacklistItems: []
    }
})

const onSubmit = handleSubmit(async (values, ctx) => {
    const errorFields = await indexBlacklistFormStore.submitIndexBlacklist(checkedItems.value, values)
    if (errorFields) {
        ctx.setErrors(errorFields)
        return
    }
    editMode.value = false
})

const deleteBlacklistItems = async () => {
    if (confirm('Вы уверены, что хотите удалить выбранные пункты чёрного списка?')) {
        await bulkDelete(checkedItems.value)
    }
}

const deleteBlacklistItem = async (blacklistItem: BlacklistItem) => {
    if (confirm(`Вы уверены, что хотите удалить пункт чёрного списка '${blacklistItem.id}' ?`)) {
        await bulkDelete([blacklistItem.uuid])
    }
}

const bulkDelete = async (ids: Array<string>) => {
    let errorsOrVoid = await blacklistStore.deleteBulkBlacklist(ids)
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

const {indexForId} = useFormHelpers<Values>('blacklistItems', values)

watch(blacklistItems, (blacklistItems: Array<BlacklistItem>) => {
    setValues({
        blacklistItems: blacklistItems.map(item => ({
            id: item.id,
            uuid: item.uuid,
            email: item.email,
            ip: item.ip,
        }))
    })
})

const perPageOptions = getPerPageOptions()

watchSelectAll()
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Чёрный список" />

            <div class="breadcrumbs">
                <a :href="routesStore.route(routeNames.ROUTE_ADMIN_TEMP_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Справочники: Чёрный список <span class="adm-fav-link"></span></h1>

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
                    <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_BLACKLIST_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
                </div>
            </div>

            <form id="form-blacklist-items" @submit="onSubmit" novalidate>
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
                            <th scope="col">Email</th>
                            <th scope="col">Ip</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="blacklistItem in blacklistItems" :key="`blacklistItem-${blacklistItem.id}`" @click="manualCheck(blacklistItem.uuid)">
                            <td>
                                <div class="form-check">
                                    <input
                                        :disabled="editMode"
                                        v-model="checkedItems"
                                        :value="blacklistItem.uuid"
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
                                        :id="`actions-dropdown-${blacklistItem.id}`"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        :disabled="editMode"
                                    ></button>
                                    <div class="dropdown-menu bx-core-popup-menu" :aria-labelledby="`actions-dropdown-${blacklistItem.id}`">
                                        <div class="bx-core-popup-menu__arrow"></div>
                                        <Link class="dropdown-item bx-core-popup-menu-item bx-core-popup-menu-item-default" :href="routesStore.route(routeNames.ROUTE_ADMIN_BLACKLIST_EDIT, {admin_blacklist: blacklistItem.id})">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                            <span class="bx-core-popup-menu-item-text">Изменить</span>
                                        </Link>
                                        <span class="bx-core-popup-menu-separator"></span>
                                        <button @click="deleteBlacklistItem(blacklistItem)" type="button" class="bx-core-popup-menu-item">
                                            <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                            <span class="bx-core-popup-menu-item-text">Удалить</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td><span class="main-grid-cell-content">{{blacklistItem.id}}</span></td>
                            <td>
                                <FormControlInput
                                    v-if="editMode && isChecked(blacklistItem.uuid)"
                                    :name="`blacklistItems[${indexForId(blacklistItem.id)}].email`"
                                    type="text"
                                    :keep-value="true"
                                />
                                <span v-else class="main-grid-cell-content">
                                    <Link
                                        :href="routesStore.route(routeNames.ROUTE_ADMIN_BLACKLIST_EDIT, {admin_blacklist: blacklistItem.id})"
                                        class="table__column-name"
                                        @click.stop=""
                                    >
                                        {{blacklistItem.email}}
                                    </Link>
                                </span>
                            </td>
                            <td>
                                <FormControlInput
                                    v-if="editMode && isChecked(blacklistItem.uuid)"
                                    :name="`blacklistItems[${indexForId(blacklistItem.id)}].ip`"
                                    type="text"
                                    :keep-value="true"
                                />
                                <template v-else>
                                    <IpDetails v-if="blacklistItem.ipDetails" :ip-details="blacklistItem.ipDetails" />
                                </template>
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
                v-if="blacklistStore.meta"
                :total="blacklistStore.meta.total"
                :current-page="blacklistStore.meta.current_page"
                :per-page="blacklistStore.getPerPageOption"
                :per-page-options="perPageOptions"
                :links="blacklistStore.meta.links"
                @update:perPage="onPerPage"
            />

            <footer key="edit-mode-on" v-if="editMode" class="footer edit-item-footer">
                <button form="form-blacklist-items" type="submit" :disabled="isSubmitting" class="btn btn-info">Сохранить</button>
                <button @click="cancel" type="button" class="btn btn-warning">Отменить</button>
            </footer>
            <footer key="edit-mode-off" v-else class="footer edit-item-footer">
                <button @click="editMode = true" :disabled="!checkedItems.length" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
                <button @click="deleteBlacklistItems" :disabled="!checkedItems.length" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
            </footer>
        </div>
    </TheLayout>
</template>
