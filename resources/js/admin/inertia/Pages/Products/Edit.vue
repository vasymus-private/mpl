<script lang="ts" setup>
import TheLayout from '@/admin/inertia/shared/layout/TheLayout.vue'
import {routeNames} from "@/admin/inertia/modules/routes"


</script>

<template>
    <TheLayout>
        <div>
            <div class="breadcrumbs">
                <a :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
                <span class="breadcrumbs__item">
                    <span class="breadcrumbs__arrow"></span>
                </span>
                <a :href="route(routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Каталог товаров</span>
                </a>
            </div>
            <h1 class="h2 adm-title">
                Товары: элемент: редактирование
            </h1>
        </div>
    </TheLayout>
</template>
