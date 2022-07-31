<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {routeNames, RouteParams} from "@/admin/inertia/modules/routes"
import {useProductsStore} from "@/admin/inertia/modules/products"
import {onUnmounted, watch} from "vue"
import {Link} from "@inertiajs/inertia-vue3"
import {AdminTab} from "@/admin/inertia/modules/common/Tabs"
import {useForm} from 'vee-validate'
import {
    getFormSchema,
    getWatchProductToFormCb,
    useCreateEditProductFormsStore
} from "@/admin/inertia/modules/forms/createEditProduct"
import Breadcrumbs from "@/admin/inertia/components/products/createEdit/parts/Breadcrumbs.vue"
import Toolbar from "@/admin/inertia/components/products/createEdit/parts/Toolbar.vue"


const productsStore = useProductsStore()
const formsStore = useCreateEditProductFormsStore()

const onTabClick = (tab: AdminTab) => {
    let u = new URL(location.href)
    let s = new URLSearchParams(u.search)
    s.set(RouteParams.activeTab, tab.value)
    u.search = s.toString()
    history.replaceState(history.state, '', u.toString())
}

const {errors, handleSubmit, values, setValues, submitCount} = useForm({
    validationSchema: getFormSchema(),
})

watch(values, newValues => {
    formsStore.setProductForm(newValues)
})

watch(() => productsStore.product, getWatchProductToFormCb(setValues))

const onSubmit = handleSubmit((values, actions) => {
    console.log('--- values', values)
    console.log('--- actions', actions)
})

onUnmounted(() => {
    formsStore.setProductForm({})
})
</script>

<template>
    <TheLayout>
        <div>
            <Breadcrumbs />

            <h1 class="h2 adm-title">
                {{ formsStore.productFormTitle }}
            </h1>

            <Toolbar />

            <div class="js-nav-tabs-wrapper">
                <div class="js-nav-tabs-marker"></div>
                <ul class="nav nav-tabs item-tabs" role="tablist">
                    <li v-for="tab in formsStore.adminTabs" :key="`${tab.value}-tab`" class="nav-item" role="presentation">
                        <button
                            :class="['nav-link', tab.value === formsStore.activeTab ? 'active' : '']"
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

            <form class="position-relative" @submit="onSubmit">
                <div class="tab-content">
                    <div
                        v-for="tab in formsStore.adminTabs"
                        :key="`${tab.value}-content`"
                        :class="['tab-pane', 'p-3', 'fade', tab.value === formsStore.activeTab ? 'show active' : '']"
                        :id="`${tab.value}-content`"
                        role="tabpanel"
                        :aria-labelledby="`${tab.value}-tab`"
                    >
                        <component :is="tab.is" />
                    </div>
                </div>

                <div class="js-edit-footer-wrapper">
                    <div class="edit-item-footer js-edit-item-footer">
                        <button type="submit" class="btn btn-primary mb-2 btn__save mr-2">Сохранить</button>

                        <Link :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {category_id : productsStore.product?.category_id})" type="button" class="btn btn-info mb-2 btn__default">Отменить</Link>

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
