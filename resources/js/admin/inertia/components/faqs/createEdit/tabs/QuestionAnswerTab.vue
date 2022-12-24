<script lang="ts" setup>
import {computed} from "vue"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import Description from "@/admin/inertia/components/forms/parts/Description.vue"
import {useFaqsStore} from "@/admin/inertia/modules/faqs"


const faqsStore = useFaqsStore()
const routesStore = useRoutesStore()

const uploadUrl = computed(() => {
    return faqsStore.faq?.id
        ? routesStore.route(routeNames.ROUTE_ADMIN_AJAX_FAQ_IMAGE_UPLOAD, {admin_faq: faqsStore.faq.id})
        : null
})
</script>

<template>
    <div class="item-edit product-edit">
        <Description
            id="question"
            label="Вопрос"
            name="question"
            :upload-url="uploadUrl"
        />

        <Description
            id="answer"
            label="Ответ"
            name="answer"
            :upload-url="uploadUrl"
        />
    </div>
</template>
