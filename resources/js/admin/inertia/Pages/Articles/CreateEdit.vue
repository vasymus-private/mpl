<script lang="ts" setup>
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import Breadcrumbs from '@/admin/inertia/components/articles/createEdit/parts/Breadcrumbs.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import {useRoutesStore} from "@/admin/inertia/modules/routes"
import {AdminTab, UrlParams} from "@/admin/inertia/modules/common/types"
import {useForm} from "vee-validate"
import {watch} from "vue"
import {Values} from "@/admin/inertia/modules/forms/createEditArticle/types"
import Toolbar from "@/admin/inertia/components/articles/createEdit/parts/Toolbar.vue"
import {routeNames} from "@/admin/inertia/modules/routes"
import {useCreateEditArticleFormStore, getWatchArticleToFormCb, getFormSchema} from "@/admin/inertia/modules/forms/createEditArticle"
import {useArticlesStore} from "@/admin/inertia/modules/articles"


const createEditArticleFormStore = useCreateEditArticleFormStore()
const articlesStore = useArticlesStore()
const routesStore = useRoutesStore()

const onTabClick = (tab: AdminTab) => {
    routesStore.replaceUrlParamState(UrlParams.active_tab, tab.value)
}

const {errors, handleSubmit, values, setValues, submitCount, isSubmitting} = useForm<Values>({
    validationSchema: getFormSchema(),
})
watch(() => articlesStore.article, getWatchArticleToFormCb(setValues))

const onSubmit = handleSubmit((values: Values, ctx) => {
    createEditArticleFormStore.submitCreateEditArticle(values, ctx)
})
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Статья" />

            <Breadcrumbs />

            <h1 class="h2 adm-title">
                {{ createEditArticleFormStore.articleFormTitle }}
            </h1>

            <Toolbar />

            <div class="js-nav-tabs-wrapper">
                <div class="js-nav-tabs-marker"></div>
                <ul class="nav nav-tabs item-tabs" role="tablist">
                    <li v-for="tab in createEditArticleFormStore.allAdminTabs" :key="`${tab.value}-tab`" class="nav-item" role="presentation">
                        <button
                            :class="['nav-link', tab.value === routesStore.activeTab(createEditArticleFormStore.allAdminTabs) ? 'active' : '']"
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
                        v-for="tab in createEditArticleFormStore.allAdminTabs"
                        :key="`${tab.value}-content`"
                        :class="['tab-pane', 'p-3', 'fade', tab.value === routesStore.activeTab(createEditArticleFormStore.allAdminTabs) ? 'show active' : '']"
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

                        <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_ARTICLES_INDEX)" type="button" class="btn btn-info mb-2 btn__default">Отменить</Link>

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
