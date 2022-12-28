<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {Inertia} from "@inertiajs/inertia"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {computed} from "vue"
import {useArticlesStore} from "@/admin/inertia/modules/articles"


const articlesStore = useArticlesStore()
const routesStore = useRoutesStore()
const toastsStore = useToastsStore()

const handleDelete = async () => {
    if (!articlesStore.article?.id) {
        return
    }

    if (confirm(`Вы уверены, что хотите удалить статью?`)) {
        let errorsOrVoid = await articlesStore.deleteBulkArticles([articlesStore.article.uuid])
        if (!errorsOrVoid) {
            Inertia.visit(
                routesStore.route(
                    routeNames.ROUTE_ADMIN_ARTICLES_INDEX
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
    return !articlesStore.isCreatingArticleRoute && articlesStore.article?.is_active
})
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_ARTICLES_INDEX)" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Статьи</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>

                <a v-if="canBeViewedInWebShop" class="mx-2" :href="articlesStore.article?.web_route" target="_blank">В магазин</a>
            </div>
            <div v-if="!articlesStore.isCreatingArticleRoute" class="col-sm-5 d-flex align-items-center">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_ARTICLES_CREATE)" class="btn btn-info mx-1">Добавить</Link>
                <button type="button" @click="handleDelete" class="btn btn-danger mx-1">Удалить</button>
            </div>
        </div>
    </div>
</template>
