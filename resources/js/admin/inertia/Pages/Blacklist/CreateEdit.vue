<script lang="ts" setup>
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import Breadcrumbs from '@/admin/inertia/components/blacklist/createEdit/parts/Breadcrumbs.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import {useRoutesStore} from "@/admin/inertia/modules/routes"
import {AdminTab, UrlParams} from "@/admin/inertia/modules/common/types"
import {useForm} from "vee-validate"
import {Values} from "@/admin/inertia/modules/forms/createEditBlacklist/types"
import {getFormSchema, getWatchBlacklistToFormCb, useCreateEditBlacklistFormStore} from "@/admin/inertia/modules/forms/createEditBlacklist"
import {watch} from "vue"
import Toolbar from "@/admin/inertia/components/blacklist/createEdit/parts/Toolbar.vue"
import {routeNames} from "@/admin/inertia/modules/routes"
import {useBlacklistStore} from "@/admin/inertia/modules/blacklist"


const createEditBlacklistFormStore = useCreateEditBlacklistFormStore()
const blacklistStore = useBlacklistStore()
const routesStore = useRoutesStore()

const onTabClick = (tab: AdminTab) => {
    routesStore.replaceUrlParamState(UrlParams.active_tab, tab.value)
}

const {errors, handleSubmit, values, setValues, submitCount, isSubmitting} = useForm<Values>({
    validationSchema: getFormSchema(),
})
watch(() => blacklistStore.blacklist, getWatchBlacklistToFormCb(setValues))

const onSubmit = handleSubmit((values: Values, ctx) => {
    createEditBlacklistFormStore.submitCreateEditBlacklist(values, ctx)
})
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Пункт чёрного списка" />

            <Breadcrumbs />

            <h1 class="h2 adm-title">
                {{ createEditBlacklistFormStore.blacklistFormTitle }}
            </h1>

            <Toolbar />

            <div class="js-nav-tabs-wrapper">
                <div class="js-nav-tabs-marker"></div>
                <ul class="nav nav-tabs item-tabs" role="tablist">
                    <li v-for="tab in createEditBlacklistFormStore.allAdminTabs" :key="`${tab.value}-tab`" class="nav-item" role="presentation">
                        <button
                            :class="['nav-link', tab.value === routesStore.activeTab(createEditBlacklistFormStore.allAdminTabs) ? 'active' : '']"
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

            <form class="position-relative" @submit.prevent="onSubmit" novalidate>
                <div class="tab-content">
                    <div
                        v-for="tab in createEditBlacklistFormStore.allAdminTabs"
                        :key="`${tab.value}-content`"
                        :class="['tab-pane', 'p-3', 'fade', tab.value === routesStore.activeTab(createEditBlacklistFormStore.allAdminTabs) ? 'show active' : '']"
                        :id="`${tab.value}-content`"
                        role="tabpanel"
                        :aria-labelledby="`${tab.value}-tab`"
                    >
                        <component :is="tab.is" />
                    </div>
                </div>

                <div class="js-edit-footer-wrapper">
                    <div class="edit-item-footer js-edit-item-footer">
                        <button type="submit" :disabled="isSubmitting" class="btn btn-primary mb-2 btn__save mr-2">Сохранить</button>

                        <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_BLACKLIST_INDEX)" type="button" class="btn btn-info mb-2 btn__default">Отменить</Link>

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
