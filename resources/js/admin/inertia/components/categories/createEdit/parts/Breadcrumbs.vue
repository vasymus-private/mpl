<script lang="ts" setup>
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"


const routesStore = useRoutesStore()
</script>

<template>
    <div class="breadcrumbs">
        <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </Link>
        <span class="breadcrumbs__item">
            <span class="breadcrumbs__arrow"></span>
        </span>
        <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_INDEX)" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Каталог категорий</span>
        </Link>
    </div>
</template>
