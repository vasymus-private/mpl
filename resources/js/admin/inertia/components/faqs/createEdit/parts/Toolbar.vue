<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {Inertia} from "@inertiajs/inertia"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {useFaqsStore} from "@/admin/inertia/modules/faqs"
import {computed} from "vue"


const faqsStore = useFaqsStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()

const handleDelete = async () => {
    if (!faqsStore.faq?.id) {
        return
    }

    if (confirm(`Вы уверены, что хотите удалить вопрос-ответ?`)) {
        let errorsOrVoid = await faqsStore.deleteBulkFaqs([faqsStore.faq.uuid])
        if (!errorsOrVoid) {
            Inertia.visit(
                routesStore.route(
                    routeNames.ROUTE_ADMIN_FAQ_INDEX
                )
            )
            return
        }

        for (let key in errorsOrVoid) {
            toastsStore.error({
                title: key,
                message: errorsOrVoid[key]
            })
        }
    }
}
const canBeViewedInWebShop = computed((): boolean => {
    return !faqsStore.isCreatingFaqRoute && !faqsStore.faq?.parent_id && faqsStore.faq?.slug && faqsStore.faq?.is_active
})
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_FAQ_INDEX)" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Вопросы-ответы</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>

                <a v-if="canBeViewedInWebShop" class="mx-2" :href="routesStore.route(routeNames.ROUTE_WEB_FAQ_SHOW, {faq_slug: faqsStore.faq.slug})" target="_blank">В магазин</a>
            </div>
            <div v-if="!faqsStore.isCreatingFaqRoute" class="col-sm-5 d-flex align-items-center">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_FAQ_CREATE)" class="btn btn-info mx-1">Добавить</Link>
                <button type="button" @click="handleDelete" class="btn btn-danger mx-1">Удалить</button>
            </div>
        </div>
    </div>
</template>
