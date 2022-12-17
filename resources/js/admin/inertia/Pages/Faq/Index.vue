<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import {Link, Head} from "@inertiajs/inertia-vue3"
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"
import useSearchInput from "@/admin/inertia/composables/useSearchInput"

const routesStore = useRoutesStore()
const {searchInput, onPerPage, handleSearch, handleClearSearch} = useSearchInput()
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Вопросы - Ответы" />

            <div class="breadcrumbs">
                <a :href="routesStore.route(routeNames.ROUTE_ADMIN_TEMP_HOME)" class="breadcrumbs__item">
                    <span class="breadcrumbs__text">Рабочий стол</span>
                </a>
            </div>

            <h1 class="adm-title">Справочники: Вопросы - Ответы <span class="adm-fav-link"></span></h1>

            <div class="search form-group row">
                <div class="col-xs-12 col-sm-10">
                    <div class="input-group mb-3">
                        <input
                            v-model="searchInput"
                            type="text"
                            class="form-control"
                            placeholder="Фильтр + поиск"
                            aria-label="Фильтр + поиск"
                            aria-describedby="search-button"
                        />
                        <button
                            v-if="searchInput"
                            @click="handleClearSearch"
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
                    <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_FAQ_CREATE)" class="btn btn-add btn-secondary">Создать</Link>
                </div>
            </div>
        </div>
    </TheLayout>
</template>
