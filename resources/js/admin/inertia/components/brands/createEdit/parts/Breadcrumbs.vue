<script lang="ts" setup>
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames} from "@/admin/inertia/modules/routes"
</script>

<template>
    <div class="breadcrumbs">
        <Link :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Рабочий стол</span>
        </Link>
        <span class="breadcrumbs__item">
            <span class="breadcrumbs__arrow"></span>
        </span>
        <Link :href="route(routeNames.ROUTE_ADMIN_BRANDS_TEMP_INDEX)" class="breadcrumbs__item">
            <span class="breadcrumbs__text">Производители</span>
        </Link>
    </div>
</template>
