<script>
import axios from 'axios'


export default {
    computed: {
        name() {
            return this.$page.props.auth.user.name;
        }
    },
    methods: {
        logout() {
            axios.post(this.route('logout'))
                .then(() => {
                    window.location.href = '/'
                })
        }
    }
}
</script>

<template>
    <header id="header" class="header">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" :href="route('home')">Сайт</a>
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
                <ul class="navbar-nav mr-auto header-menu">
                    <li class="nav-item active">
                        <a class="header-link" :href="route('admin.home')">Администрирование <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="adm-header-user-block">
                            {{ name }}
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
