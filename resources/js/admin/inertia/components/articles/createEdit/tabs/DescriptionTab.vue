<script lang="ts" setup>
import {computed} from "vue"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import Description from "@/admin/inertia/components/forms/parts/Description.vue"
import {useArticlesStore} from "@/admin/inertia/modules/articles"


const articlesStore = useArticlesStore()
const routesStore = useRoutesStore()

const uploadUrl = computed(() => {
    return articlesStore.article?.id
        ? routesStore.route(routeNames.ROUTE_ADMIN_AJAX_ARTICLE_IMAGE_UPLOAD, {admin_article: articlesStore.article.id})
        : null
})
</script>

<template>
    <div class="item-edit product-edit">
        <Description
            id="description"
            label="Описание"
            name="description"
            :upload-url="uploadUrl"
        />
    </div>
</template>
