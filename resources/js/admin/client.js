import Vue from "vue"
import { createInertiaApp } from "@inertiajs/inertia-vue"
import { ZiggyVue } from "ziggy"
import { Ziggy } from "@/helpers/ziggy"
import { BootstrapVue } from "bootstrap-vue"

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)
        Vue.use(ZiggyVue, Ziggy)
        Vue.use(BootstrapVue)

        new Vue({
            render: (h) => h(App, props),
        }).$mount(el)
    },
})
