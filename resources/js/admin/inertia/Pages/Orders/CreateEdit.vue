<script lang="ts" setup>
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import Breadcrumbs from "@/admin/inertia/components/orders/createEdit/parts/Breadcrumbs.vue"
import {useCreateEditOrderFormStore, getFormSchema, getWatchOrderToFormCb} from "@/admin/inertia/modules/forms/createEditOrder"
import Toolbar from "@/admin/inertia/components/orders/createEdit/parts/Toolbar.vue"
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import {UrlParams, AdminTab, TabEnum} from "@/admin/inertia/modules/common/types"
import {Link} from "@inertiajs/inertia-vue3"
import {useForm} from "vee-validate"
import {Values} from "@/admin/inertia/modules/forms/createEditOrder/types"
import {watch} from "vue"
import {useOrdersStore} from "@/admin/inertia/modules/orders"
import StickyFooter from '@/admin/inertia/components/parts/StickyFooter.vue'


const createEditOrderFormStore = useCreateEditOrderFormStore()
const routesStore = useRoutesStore()
const ordersStore = useOrdersStore()

const onTabClick = (tab: AdminTab) => {
    routesStore.replaceUrlParamState(UrlParams.active_tab, tab.value)
}

const {errors, handleSubmit, values, setValues, submitCount, isSubmitting} = useForm<Values>({
    validationSchema: getFormSchema(),
})

watch(() => ordersStore.order, getWatchOrderToFormCb(setValues))

const onSubmit = handleSubmit((values, actions) => {
    createEditOrderFormStore.submitCreateEditOrder(values, actions)
})
</script>

<template>
    <TheLayout>
        <div>
            <Breadcrumbs />

            <h1 class="h2 adm-title">
                {{ createEditOrderFormStore.orderFormTitle }}
            </h1>

            <Toolbar />

            <div class="js-nav-tabs-wrapper">
                <div class="js-nav-tabs-marker"></div>
                <ul class="nav nav-tabs item-tabs" role="tablist">
                    <li v-for="tab in createEditOrderFormStore.allAdminTabs" :key="`${tab.value}-tab`" class="nav-item" role="presentation">
                        <button
                            :class="['nav-link', tab.value === routesStore.activeTab(createEditOrderFormStore.allAdminTabs, TabEnum.order) ? 'active' : '']"
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
                        v-for="tab in createEditOrderFormStore.allAdminTabs"
                        :key="`${tab.value}-content`"
                        :class="['tab-pane', 'p-3', 'fade', tab.value === routesStore.activeTab(createEditOrderFormStore.allAdminTabs, TabEnum.order) ? 'show active' : '']"
                        :id="`${tab.value}-content`"
                        role="tabpanel"
                        :aria-labelledby="`${tab.value}-tab`"
                    >
                        <component :is="tab.is" />
                    </div>
                </div>

                <StickyFooter>
                    <button type="submit" :disabled="isSubmitting" class="btn btn-primary mb-2 btn__save mr-2">Сохранить</button>

                    <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_ORDERS_TEMP_INDEX)" type="button" class="btn btn-info mb-2 btn__default">Отменить</Link>
                </StickyFooter>
            </form>

            <template v-if="submitCount > 0">
                <div v-for="error in errors" :key="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ error }}
                </div>
            </template>
        </div>
    </TheLayout>
</template>
