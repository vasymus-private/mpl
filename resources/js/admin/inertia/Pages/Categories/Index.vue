<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {Link} from "@inertiajs/inertia-vue3"
import useRoute from "@/admin/inertia/components/composables/useRoute"
import {storeToRefs} from "pinia"
import useSearchInput from "@/admin/inertia/components/composables/useSearchInput"

const routesStore = useRoutesStore()
const {fullUrl} = storeToRefs(routesStore)
const {visit, removeUrlParam} = useRoute(fullUrl)
const {searchInput, handleSearch, handleClear} = useSearchInput(fullUrl)

</script>

<template>
    <TheLayout>
        <div>
            <div class="breadcrumbs">
                <a :href="route(routeNames.ROUTE_ADMIN_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Каталог товаров: Разделы <span class="adm-fav-link"></span></h1>

            <div class="search form-group row">
                <div class="col-xs-12 col-sm-10">
                    <div class="input-group mb-3">
                        <template v-for="option in routesStore.categoriesUrlParamOptions" :key="`${option.type}-${option.value}`">
                            <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{option.label}}</span>
                            <button @click="removeUrlParam(option.type)" class="btn input-group-prepend__remove" type="button"></button>
                        </template>
                        <input
                            v-model="searchInput"
                            type="text"
                            class="form-control"
                            placeholder="Фильтр + поиск"
                            aria-label="Фильтр + поиск"
                            aria-describedby="search-button"
                        />
                        <button
                            @click="handleClear"
                            class="btn-outline-secondary"
                            type="button"
                        ><i class="fa fa-times" aria-hidden="true"></i></button>
                        <button
                            @click="handleSearch"
                            class="btn-outline-secondary search-icon"
                            type="button"
                            id="search-button"
                        ><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <Link :href="route(routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
                </div>
            </div>
        </div>
    </TheLayout>
</template>
