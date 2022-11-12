<script lang="ts" setup>
import axios from 'axios'
import {useAuthStore} from "@/admin/inertia/modules/auth"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {Link} from "@inertiajs/inertia-vue3"


const authStore = useAuthStore()
const routesStore = useRoutesStore()

const logout = () => {
    axios.post(routesStore.route(routeNames.ROUTE_LOGOUT))
        .then(() => {
            window.location.href = '/'
        })
}
</script>

<template>
    <header id="header" class="header">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="/">Сайт</a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto header-menu">
                    <li class="nav-item active">
                        <Link class="header-link" :href="routesStore.route(routeNames.ROUTE_ADMIN_TEMP_HOME)">Администрирование <span class="sr-only">(current)</span></Link>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="adm-header-user-block">
                            {{ authStore.userName }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <button type="button" @click="logout" class="adm-header-exit">Выйти</button>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="adm-header-bottom"></div>
    </header>
</template>
